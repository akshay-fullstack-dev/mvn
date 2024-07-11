<?php

namespace App\Console\Commands;

use App\Repositories\Interfaces\IBookingPaymentRepository;
use Illuminate\Console\Command;
use App\Enum\BookingEnum;
use App\Enum\NotificationEnum;
use App\Helpers\V1\PushNotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Traits\BookingTrait;
use Carbon\Carbon;
use App\Traits\LangTrait;
use App\User;
use Illuminate\Support\Facades\Log;
use IntersoftStripe\Http\Services\StripePaymentProcess;


class AutoCancelBookingCommand extends Command
{
    use LangTrait,BookingTrait;
    
    private $booking_payment;
    private $stripePayment;
    private $lang = 'Api/v1/client/booking';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:cancel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is used to cancel the booking after a certain time';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(IBookingPaymentRepository $booking_payment, StripePaymentProcess $stripePaymentProcess)
    {
        parent::__construct();
        $this->stripePayment = $stripePaymentProcess;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->stripePayment = new StripePaymentProcess();
        $lower_date_limit = Carbon::now()->addMinutes(-BookingEnum::BOOKING_CANCEL_CRONE_TIME_IN_MINUTES);
        $cancel_bookings = Booking::where('created_at', '<', $lower_date_limit)->whereNotNull('vendor_id')->requestedBookings()->with('customer_details', 'booking_payment')->get();
        if ($cancel_bookings->count() > 0) {
            foreach ($cancel_bookings as $booking) {
                if ($booking->BookingEnum::PackageBooking) {
                    $this->removeVendor($booking);
                } else {
                    $this->cancelBooking($booking);
                }
            }
        }
    }

    private function removeVendor($booking)
    {
        $booking->vendor_id = null;
        $booking->save();
        return true;
        // ! we have to send the web push notification
    }

    private function cancelBooking($booking)
    {
        $booking->booking_status = BookingEnum::bookingCancelled;
        $booking->save();
        $booking_payment = $booking->booking_payment;
        $booking_payment->refund_amount = $booking_payment->total_amount_paid + $booking_payment->via_wallet;
        $booking_payment->is_refunded = BookingEnum::PaymentRefunded;
        $refund_status = $this->refundPayment($booking_payment, $booking, $booking_payment->refund_amount);
        if ($refund_status) {
            $booking_payment->payment_settled = BookingEnum::PaymentSettled;
        } else {
            $booking_payment->is_pending_payment = BookingEnum::PaymentPending;
            $booking_payment->payment_settled = BookingEnum::PaymentNotSettled;
        }
        $booking->booking_status_history()->create(['booking_status' => BookingEnum::bookingCancelled]);
        $booking_payment->push();
        $this->sendSuccessCancelMessage($booking);
        $this->sendPushNotificationToVendor($booking);
        return true;
    }


    private function sendSuccessCancelMessage($booking)
    {
        PushNotificationHelper::send(NotificationEnum::NOTIFICATION_SEND_BY_ADMIN, $booking->customer_details->id, $this->getMessage('booking_cancelled_title'), $this->getMessage('you_booking_has_been_cancelled_because_of_vendor_unavailability_description', ['date' => $booking->booking_start_time]), NotificationEnum::BOOKING_CANCELLED);
    }

    private function sendPushNotificationToVendor($booking)
    {
        PushNotificationHelper::send(NotificationEnum::NOTIFICATION_SEND_BY_ADMIN, $booking->vendor_id, $this->getMessage('booking_cancelled_title'), $this->getMessage('your_requested_service_has_cancelled', ['date' => $booking->booking_start_time]), NotificationEnum::BOOKING_CANCELLED);
    }
}

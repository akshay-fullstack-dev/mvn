<?php

namespace App\Console\Commands;

use App\Repositories\Interfaces\IBookingPaymentRepository;
use Illuminate\Console\Command;
use App\Enum\BookingEnum;
use App\Enum\NotificationEnum;
use App\Helpers\V1\CurrencyHelper;
use App\Helpers\V1\PushNotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingPayment;
use Carbon\Carbon;
use App\Traits\LangTrait;
use Exception;
use Illuminate\Support\Facades\Log;
use IntersoftStripe\Http\Services\StripePaymentProcess;


class PaymentSettlementCommand extends Command
{
    use LangTrait;
    private $booking_payment;
    private $stripePayment;
    private $lang = 'Api/v1/client/booking';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:settle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is used to settle the payment or transfer the amount to the vendor';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(StripePaymentProcess $stripePaymentProcess)
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
        $all_booking_payments = BookingPayment::whereIs_pending_payment(BookingEnum::PaymentPending)->with(['bookings' => function ($query) {
            $query->first();
        }])->get();
        $booking_count = $all_booking_payments->count();
        Log::alert('cron running at' . Carbon::now() . ' Booking count:-' . $booking_count);
        if ($booking_count > 0) {
            foreach ($all_booking_payments as $booking_payment) {
                try {
                    if ($booking_payment->is_refunded == BookingEnum::PaymentRefunded) {
                        $booking_data = $booking_payment->bookings->first();
                        if (!$booking_data)
                            continue;
                        $this->refundPayment($booking_payment, $booking_data->customer_details);
                    } else {
                        // if there no booking found then we will not transfer the payment
                        $booking_data = $booking_payment->bookings->first();
                        if (!$booking_data)
                            continue;
                        $this->transferPayment($booking_payment, $booking_data->booking_vendor);
                    }
                } catch (Exception $ex) {
                    continue;
                }
            }
        }
    }
    // refund teh payment
    private function refundPayment(BookingPayment $booking_payment, $booking_customer)
    {
        if ($booking_payment->refund_amount > 0) {
            $notification_description_message = $this->getMessage('partial_refund_send_notification_description_message', ['value' => CurrencyHelper::format_currency_us_local($booking_payment->refund_amount)]);
            $refund_status = $this->stripePayment->refund_payment($booking_payment->id, $booking_payment->refund_amount);
        } else {
            $refund_status = $this->stripePayment->refund_payment($booking_payment->id);
            $notification_description_message = $this->getMessage('full_refund_send_notification_description_message');
        }
        if ($refund_status) {
            $booking_payment->payment_settled = BookingEnum::PaymentSettled;
            $booking_payment->is_pending_payment = BookingEnum::PaymentNotPending;
            $booking_payment->save();
            PushNotificationHelper::send(NotificationEnum::NOTIFICATION_SEND_BY_ADMIN, $booking_customer->id, $this->getMessage('payment_transferred'), $notification_description_message, NotificationEnum::PAYMENT_TRANSFER_SUCCESS);
        }
    }

    private  function transferPayment(BookingPayment $booking_payment, $booking_vendor)
    {
        $transferVendorCharges = round(($booking_payment->delivery_charge_received_by_vendor + $booking_payment->basic_service_charge_received_by_vendor), 2);
        $transfer_stripe_payment = $this->transferCharge($booking_payment, $transferVendorCharges, $booking_vendor);
        // if payment is transferred
        if ($transfer_stripe_payment) {
            $booking_payment->payment_settled = BookingEnum::PaymentSettled;
            $booking_payment->is_pending_payment = BookingEnum::PaymentNotPending;
            $booking_payment->save();
            PushNotificationHelper::send(NotificationEnum::NOTIFICATION_SEND_BY_ADMIN, $booking_vendor->id, $this->getMessage('payment_transferred'), $this->getMessage('payment_transferred_description', ['value' => CurrencyHelper::format_currency_us_local($transferVendorCharges)]), NotificationEnum::PAYMENT_TRANSFER_SUCCESS);
        }
        return;
    }
    private function transferCharge($booking_payment, $transferVendorCharges, $booking_vendor)
    {
        return $this->stripePayment->transferCharges($transferVendorCharges, $booking_vendor->stripe_connect_id, $booking_payment->id);
    }
}

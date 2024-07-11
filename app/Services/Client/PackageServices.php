<?php

namespace App\Services\Client;

use App\Enum\BookingEnum;
use App\Enum\NotificationEnum;
use App\Enum\PackageEnum;
use App\Exceptions\BadRequestException;
use App\Exceptions\RecordNotFoundException;
use App\Helpers\V1\BookingHelper;
use App\Helpers\V1\PushNotificationHelper;
use App\Http\Requests\V1\ClientRequests\Package\BookPackage;
use App\Http\Requests\V1\ClientRequests\Package\CancelPackageBooking;
use App\Http\Requests\V1\ClientRequests\Package\PackageListRequest;
use App\Repositories\Interfaces\IAuthUserRepository;
use App\Repositories\Interfaces\IBookingPaymentRepository;
use App\Repositories\Interfaces\IBookingRepository;
use App\Repositories\Interfaces\IPackageMaintenanceRepository;
use App\Repositories\Interfaces\IPackageRepository;
use App\Repositories\Interfaces\IUserServiceRepository;
use App\Repositories\Interfaces\IUserVehicleRepository;
use App\Services\Interfaces\Client\IPackageServices;
use App\Services\Interfaces\ICouponServices;
use App\Traits\BookingTrait;
use App\Traits\LangTrait;
use App\Traits\LocationTrait;
use App\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use IntersoftStripe\Http\Services\StripePaymentProcess;

class PackageServices implements IPackageServices
{
    use LangTrait, LocationTrait, BookingTrait;

    private $iPackageRepository;
    private $userVehicle;
    private $iUserServiceRepository;
    private $authRepository;
    private $booking_payment;
    private $stripePayment;
    private $bookingRepository;
    private $packagemaintain;
    private $lang = 'Api/v1/client/package';
    public function __construct(
        IPackageRepository $iPackageRepository,
        IUserServiceRepository $iUserServiceRepository,
        IBookingRepository $bookingRepository,
        IBookingPaymentRepository $booking_payment,
        IUserVehicleRepository $userVehicle,
        StripePaymentProcess $stripePayment,
        IAuthUserRepository $authRepository,
        ICouponServices $couponServices
    ) {
        $this->iPackageRepository = $iPackageRepository;
        $this->iUserServiceRepository = $iUserServiceRepository;
        $this->booking_payment = $booking_payment;
        $this->couponServices = $couponServices;
        $this->stripePayment = $stripePayment;
        $this->authRepository = $authRepository;
        $this->userVehicle = $userVehicle;
        $this->bookingRepository = $bookingRepository;
    }
    public function index(PackageListRequest $request)
    {
        if (!Request::header('time-zone')) {
            throw new RecordNotFoundException('timezone not received');
        }
        $item_per_page = $request->item_per_page ?? PackageEnum::ITEM_PER_PAGE;
        $packages = $this->iPackageRepository->get_active_package(Request::header('time-zone'), $item_per_page);
        if (!$packages->count() > 0) {
            throw new RecordNotFoundException('Record not found.');
        }
        $package_in_near_user = $packages->reject(function ($package) use ($request) {
            $package_service_ids = $package->package_services->pluck('service_id')->toArray();
            $vendor_services = $this->iUserServiceRepository->get_vendor_service($package_service_ids);
            if (!$vendor_services->count() > 0) {
                return true;
            }
            // filter the service
            $available_service_vendor = [];
            foreach ($vendor_services as $single_service) {
                if (!isset($available_service_vendor[$single_service->user_id])) {
                    $available_service_vendor[$single_service->user_id][] = $single_service->service_id;
                } else {
                    array_push($available_service_vendor[$single_service->user_id], $single_service->service_id);
                }
            }
            $available_vendors = $this->removeExtraVendor($available_service_vendor, $package_service_ids);
            if (empty($available_vendors)) {
                return true;
            }
        });
        if (!$package_in_near_user->count() > 0) {
            throw new RecordNotFoundException('package not found.');
        }
        return $package_in_near_user;
    }

    private function removeExtraVendor(array $available_service_vendor, array $package_service_ids)
    {
        $available_vendor = [];
        foreach ($available_service_vendor as $key => $vendor_service) {
            if (count($vendor_service) != count($package_service_ids)) {
                unset($available_service_vendor[$key]);
            } else {
                array_push($available_vendor, $key);
            }
        }
        return $available_vendor;
    }

    /**
     * this function is used to book the service 
     * this booking is based on the package system
     *
     * @param BookPackage $request
     * @return array
     */
    public function bookPackage(BookPackage $request)
    {
        //checking booking type
        if ($request->booking_type === BookingEnum::NormalBooking) {
            throw new RecordNotFoundException('invalid booking type');
        }
        if (!$request->header('time-zone')) {
            throw new BadRequestException('timezone not received');
        }
        $auth_user = Auth::user();
        //checking requested address is valid or not
        $addressVerifying = $this->authRepository->user_verified_address($auth_user->id, $request->address_id);
        if (!$addressVerifying) {
            throw new RecordNotFoundException('The selected address id is invalid');
        }
        //checking package ID exist or not-
        $package = $this->iPackageRepository->getSingleActivePackage($request->package_id, $request->header('time-zone'));
        if (!$package) {
            throw new RecordNotFoundException($this->getMessage('package_not_found'));
        }
        // check this package is already used or not
        $order_id = Str::uuid()->toString();
        $payment_data = BookingHelper::getPackagePaymentData($request);
        $booking_data = BookingHelper::getBookingData($request);
        $vendor_admin_bookingCharge_split = BookingHelper::processBookingPaymentPackage($payment_data, $package->package_services->count());
        if ($payment_data['coupon_id'] != null) {
            $coupon = $this->couponServices->validateCoupon($auth_user->id, $payment_data);
        }
        $stripe_payment = $this->stripePayment->intentPayment($payment_data['total_amount_paid'], $payment_data['card_token'], $payment_data['currency_code'], $auth_user);
        if (!$stripe_payment) {
            throw new Exception($this->getMessage('payment_unsuccessful'));
        }
        // store payment
        $booking_payment = $this->booking_payment->create(BookingHelper::insertBookingPackageData($payment_data, $vendor_admin_bookingCharge_split));
        $this->stripePayment->updateHistoryTable($stripe_payment->charge_id, $booking_payment->id);
        //booking data create
        $bookings_to_insert = BookingHelper::getPackageBookingInsertData($auth_user->id, $booking_data, $order_id, $booking_payment->id, $package->package_services);
        // create a booking
        $booking_payment->bookings()->insert($bookings_to_insert);

        if ($payment_data['coupon_id'] != null) {
            $this->couponServices->addCouponHistory($auth_user->id, $coupon, $booking_payment->id);
        }
        // deduct user wallet amount after booking
        if ($payment_data['via_wallet'] > 0) {
            $auth_user->wallet_money = $auth_user->wallet_money - $payment_data['via_wallet'];
            $auth_user->save();
        }
        // add package history
        $package->package_history()->create(['user_id' => $auth_user->id, 'order_id' => $order_id,]);
        $PackageBookings = $booking_payment->bookings()->where('order_id', $order_id)->get();
        $insert_data = [];
        foreach ($PackageBookings as $packageBooking) {
            $insert_data[] = [
                'booking_id' => $packageBooking->id,
                'booking_status' => $packageBooking->booking_status
            ];
        }
        $packageBooking->booking_status_history()->insert($insert_data);
        PushNotificationHelper::send($auth_user->id, $auth_user->id, $this->getMessage('booking_successful'), $this->getMessage('booking_description', ['username' => $auth_user->first_name]), NotificationEnum::BOOKING_NOTIFICATION);

        return [
            'order_id' => $order_id,
            'booking_type' => BookingEnum::PackageBooking,
        ];
    }

    public function getUserAllPurchasedPackageList(Request $request)
    {
        $auth_user = Auth::user();
        $item_per_page = $request->item_per_page ?? PackageEnum::ITEM_PER_PAGE;
        $package = $auth_user->user_packages()->with('booking_by_order_id', 'package.package_services')->paginate($item_per_page);
        if (!$package->count() > 0) {
            throw new RecordNotFoundException($this->getMessage('user_package_not_found'));
        }
        return collect($package->items());
    }

    public function cancelBooking(CancelPackageBooking $request)
    {
        $bookings = $this->bookingRepository->getBooking(['order_id' => $request->order_id], false);
        // check the booking if there is a booking that cannot be canceled the then we need to send them.
        foreach ($bookings as $booking) {
            // if user want to cancel this booking in between of service process then we have to show the error to the user that the user cannot cancel this booking only admin can cancel this booking from admin panel
            if ($booking->booking_status != BookingEnum::BookingConfirmed) {
                throw new BadRequestException($this->getMessage('cannot_cancel_this_booking'));
            }
        }
        $any_package_booking = $bookings->first();
        $refund_status = $this->refundPayment($any_package_booking->booking_payment, $any_package_booking, true);
        if ($refund_status) {
            $any_package_booking->booking_payment->payment_settled = BookingEnum::PaymentSettled;
        } else {
            $any_package_booking->booking_payment->is_pending_payment = BookingEnum::PaymentPending;
            $any_package_booking->booking_payment->payment_settled = BookingEnum::PaymentNotSettled;
        }
        $any_package_booking->push();
        // cancel all bookings
        $this->bookingRepository->updateBooking(['order_id' => $request->order_id], ['booking_status' => BookingEnum::bookingCancelled]);

        PushNotificationHelper::send(NotificationEnum::NOTIFICATION_SEND_BY_ADMIN, $booking->customer_details->id, $this->getMessage('booking_cancelled_title'), $this->getMessage('you_booking_has_been_cancelled_because_of_vendor_unavailability_description', ['date' => $booking->booking_start_time]), NotificationEnum::BOOKING_CANCELLED);
        return $this->getMessage('booking_cancelled_title');
    }
}

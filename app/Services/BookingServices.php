<?php

namespace App\Services;

use App\Enum\BookingEnum;
use App\Enum\CommonEnum;
use App\Enum\NotificationEnum;
use App\Enum\UserEnum;
use App\Exceptions\BadRequestException;
use App\Exceptions\RecordNotFoundException;
use App\Helpers\V1\PushNotificationHelper;
use App\Helpers\V1\BookingHelper;
use App\Http\Requests\V1\Booking\BookingDetailsRequest;
use App\Http\Requests\V1\Booking\BookServiceRequest;
use App\Http\Requests\V1\Booking\ChangeBookingStatusRequest;
use App\Http\Requests\V1\Booking\CheckVendorAvailabilityRequest;
use App\Http\Requests\V1\Booking\GetVendorLocationRequest;
use App\Http\Requests\V1\Booking\RescheduleBookingRequest;
use App\Http\Requests\V1\Booking\ServiceActionRequest;
use App\Http\Requests\V1\Booking\VendorBookingDetailsRequest;
use App\Http\Requests\V1\Booking\VendorCompletedBookingRequest;
use App\Http\Requests\V1\Service\UploadBillsRequest;
use App\Models\DeliveryCharge;
use App\Repositories\Interfaces\IAuthUserRepository;
use App\Repositories\Interfaces\IBookingPaymentRepository;
use App\Repositories\Interfaces\IBookingRepository;
use App\Repositories\Interfaces\IUserVehicleRepository;
use App\Repositories\ServiceRepository;
use App\Services\Interfaces\IBookingServices;
use App\Services\Interfaces\ICouponServices;
use App\Services\Interfaces\INotificationService;
use App\Traits\BookingTrait;
use App\Traits\LangTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use IntersoftStripe\Http\Services\StripePaymentProcess;

class BookingServices implements IBookingServices
{
	use LangTrait;
	use BookingTrait;
	private $authUserRepository;
	private $bookingRepository;
	private $stripePayment;
	private $booking_payment;
	private $notificationService;
	private $serviceRepository;
	private $userVehicle;
	private $couponServices;
	private $lang = 'Api/v1/client/booking';
	public function __construct(
		IBookingRepository $bookingRepository,
		IAuthUserRepository $authUserRepository,
		StripePaymentProcess $stripePayment,
		IBookingPaymentRepository $booking_payment,
		INotificationService $notificationService,
		ServiceRepository $serviceRepository,
		IUserVehicleRepository $userVehicle,
		ICouponServices $couponServices
	) {
		$this->bookingRepository = $bookingRepository;
		$this->authUserRepository = $authUserRepository;
		$this->stripePayment = $stripePayment;
		$this->booking_payment = $booking_payment;
		$this->notificationService = $notificationService;
		$this->serviceRepository = $serviceRepository;
		$this->userVehicle = $userVehicle;
		$this->couponServices = $couponServices;
	}

	public function bookService(BookServiceRequest $request)
	{
		$order_id = Str::uuid()->toString();
		$auth_user = Auth::user();
		$payment_data = BookingHelper::getPaymentData($request);

		$booking_data = BookingHelper::getBookingData($request);

		$delivery_charge = DeliveryCharge::first();

		$vendor_admin_booking_split = BookingHelper::processBookingPrice($payment_data, $delivery_charge);

		$validated_service =	$this->validateBookingRequest($booking_data, $payment_data, $auth_user, $request->header('time-zone'));

		// make payment 
		if ($payment_data['coupon_id'] != null) {
			$coupon = $this->couponServices->validateCoupon($auth_user->id, $payment_data);
		}
		$stripe_payment = $this->stripePayment->intentPayment($payment_data['total_amount_paid'], $payment_data['card_token'], $payment_data['currency_code'], $auth_user);

		if (!$stripe_payment)
			throw new Exception($this->getMessage('payment_unsuccessful'));
		// store payment
		$booking_payment = $this->booking_payment->create(BookingHelper::insertBookingPaymentData($payment_data, $vendor_admin_booking_split));

		// update stripe payment record api 
		$this->stripePayment->updateHistoryTable($stripe_payment->charge_id, $booking_payment->id);
		$bookings = $booking_payment->bookings()->insert(BookingHelper::getBookingInsertData($auth_user->id, $booking_data, $order_id, $validated_service, $booking_payment->id));

		if ($payment_data['coupon_id'] != null) {
			$this->couponServices->addCouponHistory($auth_user->id, $coupon, $booking_payment->id);
		}

		// deduct user wallet amount after booking 
		if ($payment_data['via_wallet'] > 0) {
			$auth_user->wallet_money = $auth_user->wallet_money - $payment_data['via_wallet'];
			$auth_user->save();
		}
		// normal bookings
		if ($booking_data['booking_type'] == BookingEnum::NormalBooking) {
			$normal_booking = $booking_payment->bookings()->where('order_id', $order_id)->first();
			$normal_booking->booking_status_history()->create(['booking_id' => $normal_booking->id, 'booking_status' => $normal_booking->booking_status]);

			PushNotificationHelper::send($auth_user->id, $booking_data['vendor_id'], $this->getMessage('you_have_new_request'), $this->getMessage('booking_description', ['username' => $auth_user->first_name]), NotificationEnum::BOOKING_NOTIFICATION);

			return [
				'booking_id' => $normal_booking->id,
				'booking_type' => BookingEnum::NormalBooking
			];
		} else {
			// package booking
			$all_booked_services = $booking_payment->bookings()->where('order_id', $order_id)->get();
			// change all package booking status
			foreach ($all_booked_services as $booked_service) {
				$booked_service->booking_status_history()->create(['booking_id' => $booked_service->id, 'booking_status' => $booked_service->booking_status]);
				$booked_service->save();
			}
			return [
				'order_id' => $order_id,
				'booking_type' => BookingEnum::PackageBooking
			];
		}
	}


	public function getBookingDetail(BookingDetailsRequest $request)
	{
		if ($request->booking_type && $request->booking_type == BookingEnum::PackageBooking && $request->order_id) {
			$item_per_page = $request->item_per_page ?? CommonEnum::PAGINATION_ITEM_PER_PAGE;
			$bookings =	$this->bookingRepository->getBookingWithDetails(['order_id' => $request->order_id], $item_per_page);
			if (!$bookings->count() > 0) {
				throw new RecordNotFoundException($this->getMessage('booking_not_found'));
			}

			foreach ($bookings as $booking) {
				$booking->near_shop_locations = $this->geAdminNearShopToVendor($booking);
				$booking_user_vehicle_details = $this->userVehicle->getDetails(['user_id' => $booking->user_id, 'vehicle_id' => $booking->vehicle_id]);
				$booking->booking_vehicle->vin_number = $booking_user_vehicle_details->vin_number ?? "";
			}
			return $bookings;
		} else {
			$booking =	$this->bookingRepository->getBooking(['id' => $request->booking_id]);
			if (!$booking)
				throw new RecordNotFoundException($this->getMessage('booking_not_found'));
			$booking_user_vehicle_details = $this->userVehicle->getDetails(['user_id' => $booking->user_id, 'vehicle_id' => $booking->vehicle_id]);
			$booking->near_shop_locations = $this->geAdminNearShopToVendor($booking);
			$booking->booking_vehicle->vin_number = $booking_user_vehicle_details->vin_number ?? "";
			return $booking;
		}
	}

	public function CheckVendorAvailability(CheckVendorAvailabilityRequest $request)
	{
		$auth_user = Auth::user();
		$payment_data = BookingHelper::getPaymentData($request);
		$booking_data = BookingHelper::getBookingData($request);
		$validated_service =	$this->validateBookingRequest($booking_data, $payment_data, $auth_user, $request->header('time-zone'));
		if (!$validated_service)
			throw new BadRequestException($this->getMessage('you_cannot_book_service'));
		return $this->getMessage('vendor_available_to_book_the_service');
	}


	public function getBookingHistory(Request $request)
	{
		$auth_user = Auth::user();
		$item_in_a_page = ($request->item_per_page && is_numeric($request->item_per_page)) ? $request->item_per_page : CommonEnum::PAGINATION_ITEM_PER_PAGE;
		$bookings =	$this->bookingRepository->getBookingWithDetails(['user_id' => $auth_user->id], $item_in_a_page);
		if (!$bookings->count() > 0)
			throw new RecordNotFoundException($this->getMessage('booking_not_found'));
		// added vin number
		foreach ($bookings as $booking) {
			$booking_user_vehicle_details = $this->userVehicle->getDetails(['user_id' => $booking->user_id, 'vehicle_id' => $booking->vehicle_id]);
			$booking->booking_vehicle->vin_number = $booking_user_vehicle_details->vin_number ?? "";
		}
		return $bookings;
	}

	/**
	 * This function is used to retrieve the bookings history for the vendor_id
	 *
	 * @param VendorBookingDetailsRequest $request
	 * @return Bookings
	 */
	public function getVendorBookingHistory(VendorBookingDetailsRequest $request)
	{
		$auth_user = Auth::user();
		$item_per_page = $request->item_per_page ?? CommonEnum::PAGINATION_ITEM_PER_PAGE;
		$booking_date = $request->booking_date ?? null;
		$bookings =	$this->bookingRepository->getBookingWithDetails(['vendor_id' => $auth_user->id], $item_per_page, $booking_date, $request->booking_status);
		if (!$bookings->count() > 0)
			throw new RecordNotFoundException($this->getMessage('booking_not_found'));
		// added vin number
		foreach ($bookings as $booking) {
			$booking_user_vehicle_details = $this->userVehicle->getDetails(['user_id' => $booking->user_id, 'vehicle_id' => $booking->vehicle_id]);
			$booking->booking_vehicle->vin_number = $booking_user_vehicle_details->vin_number ?? "";
		}
		return $bookings;
	}

	public function uploadBills(UploadBillsRequest $request)
	{
		$auth_vendor = Auth::user();
		$vendor_booking = $this->bookingRepository->findRecord(['vendor_id' => $auth_vendor->id, 'id' => $request->booking_id]);
		if (!$vendor_booking)
			throw new RecordNotFoundException($this->getMessage('booking_not_found'));
		// delete previous images
		$vendor_booking->booking_bills()->delete();
		$vendor_booking->booking_bills()->insert($this->getImageData($request->booking_bills_images, $request->booking_id));
		return $this->getMessage('booking_bill_images_uploaded_successfully');
	}
	private function getImageData($images, $booking_id)
	{
		$response = [];
		foreach ($images as $image) {
			$response[] = ['booking_id' => $booking_id, 'bill_image' => $image, 'created_at' => Carbon::now(), 'created_at' => Carbon::now()];
		}
		return $response;
	}

	/**
	 * THIS FUNCTION IS USED TO ACCEPT OR REJECT THE CUSTOMER REQUEST BY VENDOR
	 *
	 * @param BookServiceRequest $request
	 * @return void
	 */
	public function bookingAction(ServiceActionRequest $request)
	{
		$auth_vendor = Auth::user();
		$vendor_booking = $this->bookingRepository->getRequestedService(['vendor_id' => $auth_vendor->id, 'id' => $request->booking_id]);
		if (!$vendor_booking)
			throw new RecordNotFoundException($this->getMessage('booking_not_found'));
		if ($request->booking_action == BookingEnum::AcceptBooking) {
			$vendor_booking->booking_status_history()->create(['booking_status' => BookingEnum::VendorAssignedOrVendorAccepted]);
			$vendor_booking->booking_status = BookingEnum::VendorAssignedOrVendorAccepted;
			$vendor_booking->save();
			// send push notification to user
			PushNotificationHelper::send($auth_vendor->id, $vendor_booking->user_id, $this->getMessage('your_booking_accepted_by_vendor'), $this->getMessage('booking_accepted_by_vendor_description', ['service_name' => $vendor_booking->service->name, 'booking_time' => $vendor_booking->booking_start_time, 'vendor_name' => $auth_vendor->first_name]), NotificationEnum::BOOKING_ACCEPTED_NOTIFICATION);
			return $this->getMessage('successfully_accepted_booking', ['date' => $vendor_booking->booking_start_time]);
		} else {
			// reject service 
			$vendor_booking->booking_status = BookingEnum::bookingRejected;
			$vendor_booking->save();
			$vendor_booking->booking_status_history()->create(['booking_status' => BookingEnum::bookingRejected]);
			$booking_payment = $vendor_booking->booking_payment;
			// refund payment to the user
			$refund = false;
			if ($booking_payment->via_wallet > 0) {
				$customer_details = $vendor_booking->customer_details;
				$customer_details->wallet_money = $booking_payment->via_wallet + $booking_payment->total_amount_paid + $customer_details->wallet_money;
				$customer_details->push();
				$refund = true;
			} else {
				$refund_status = $this->stripePayment->refund_payment($booking_payment->id);
				if ($refund_status) {
					$refund = true;
				}
			}
			$booking_payment->is_refunded = BookingEnum::PaymentRefunded;
			if ($refund) {
				$booking_payment->payment_settled = BookingEnum::PaymentSettled;
			} else {
				$booking_payment->payment_settled = BookingEnum::PaymentNotSettled;
				$booking_payment->is_pending_payment	= BookingEnum::PaymentPending;
			}
		}

		$booking_payment->save();
		// send push notification to the user
		PushNotificationHelper::send($auth_vendor->id, $vendor_booking->user_id, $this->getMessage('your_booking_rejected'), $this->getMessage('your_booking_rejected_description', ['service_name' => $vendor_booking->service->name, 'booking_time' => $vendor_booking->booking_start_time, 'vendor_name' => $auth_vendor->first_name]), NotificationEnum::BOOKING_REJECTED_NOTIFICATION);
		return $this->getMessage('your_booking_rejected_vendor_message', ['date' => $vendor_booking->booking_start_time]);
	}


	public function changeBookingStatus(ChangeBookingStatusRequest $request)
	{
		$auth_vendor = Auth::user();

		if ($auth_vendor->role == UserEnum::user_vendor and $request->booking_status != BookingEnum::bookingCancelled) {
			if ($auth_vendor->role == UserEnum::user_vendor) {
				$vendor_booking = $this->bookingRepository->getActiveBooking(['vendor_id' => $auth_vendor->id, 'id' => $request->booking_id]);
			} else {
				$vendor_booking = $this->bookingRepository->getActiveBooking(['user_id' => $auth_vendor->id, 'id' => $request->booking_id]);
			}
			if (!$vendor_booking)
				throw new RecordNotFoundException($this->getMessage('booking_not_found'));
			$booking_payment = $vendor_booking->booking_payment;
			// ONLY VENDOR CAN CHANGE THE BOOKING ORDER STATUS EXCEPT CANCELLATION
			if ($request->booking_status == BookingEnum::VendorOutForService) {
				if ($vendor_booking->booking_status == BookingEnum::VendorOutForService)
					throw new BadRequestException($this->getMessage('booking_already_out_for_service'));
				// check if any booking is active if there is any booking pending then vendor cannot activate another booking
				$vendor_booking_already_service_ongoing = $this->bookingRepository->checkOtherActiveBooking($auth_vendor->id, $request->booking_id);
				if ($vendor_booking_already_service_ongoing->count()) {
					throw new BadRequestException($this->getMessage('cannot_change_status_already_a_booking_ongoing_phase'));
				}
				$vendor_booking->booking_status = BookingEnum::VendorOutForService;
				$vendor_booking->save();
				$vendor_booking->booking_status_history()->create(['booking_status' => BookingEnum::VendorOutForService]);

				// send push notification to both user and vendor
				// send push notification to vendor
				PushNotificationHelper::send($auth_vendor->id, $vendor_booking->vendor_id, $this->getMessage('you_out_for_service'), $this->getMessage('you_out_for_service_description', ['service_name' => $vendor_booking->service->name]), NotificationEnum::VENDOR_OUT_FOR_SERVICE);
				// user push notification
				PushNotificationHelper::send($auth_vendor->id, $vendor_booking->user_id, $this->getMessage('vendor_out_for_service'), $this->getMessage('vendor_out_for_service_description', ['service_name' => $vendor_booking->service->name]), NotificationEnum::VENDOR_OUT_FOR_SERVICE);
				return $this->getMessage('booking_status_changed_for_out_for_service');
			}
			// if vendor reached to location
			if ($request->booking_status == BookingEnum::VendorReachedLocation) {
				$vendor_booking->booking_status = BookingEnum::VendorReachedLocation;
				$vendor_booking->save();
				$vendor_booking->booking_status_history()->create(['booking_status' => BookingEnum::VendorReachedLocation]);

				PushNotificationHelper::send($auth_vendor->id, $vendor_booking->vendor_id, $this->getMessage('you_reached_location'), $this->getMessage('you_have_reached_location_description', ['service_name' => $vendor_booking->service->name]), NotificationEnum::VENDOR_REACHED_LOCATION);

				PushNotificationHelper::send($auth_vendor->id, $vendor_booking->user_id, $this->getMessage('vendor_reached_location'), $this->getMessage('vendor_reached_service_location_description', ['service_name' => $vendor_booking->service->name]), NotificationEnum::VENDOR_REACHED_LOCATION);
				return $this->getMessage('vendor_reached_location');
			}

			// if vendor stated the job
			if ($request->booking_status == BookingEnum::VendorStartedJob) {
				$vendor_booking->booking_status = BookingEnum::VendorStartedJob;
				$vendor_booking->save();
				$vendor_booking->booking_status_history()->create(['booking_status' => BookingEnum::VendorStartedJob]);

				PushNotificationHelper::send($auth_vendor->id, $vendor_booking->vendor_id, $this->getMessage('you_started_job'), $this->getMessage('you_started_job_description', ['service_name' => $vendor_booking->service->name]), NotificationEnum::VENDOR_STARTED_SERVICE_JOB);

				PushNotificationHelper::send($auth_vendor->id, $vendor_booking->user_id, $this->getMessage('vendor_started_job'), $this->getMessage('vendor_started_job_description', ['service_name' => $vendor_booking->service->name]), NotificationEnum::VENDOR_STARTED_SERVICE_JOB);
				return $this->getMessage('vendor_started_job');
			}
			if ($request->booking_status == BookingEnum::VendorJobFinished) {
				$vendor_booking->booking_status = BookingEnum::VendorJobFinished;
				$vendor_booking->save();
				$vendor_booking->booking_status_history()->create(['booking_status' => BookingEnum::VendorJobFinished]);
				$transferVendorCharges = round(($booking_payment->delivery_charge_received_by_vendor + $booking_payment->basic_service_charge_received_by_vendor), 2);

				try {
					$transfer_stripe_payment = $this->stripePayment->transferCharges($transferVendorCharges, $auth_vendor->stripe_connect_id, $booking_payment->id);
					// if payment is transferred
					if ($transfer_stripe_payment) {
						$booking_payment->payment_settled = BookingEnum::PaymentSettled;
						// send push notification to vendor the the booking successfully done and your payment is transferred to you.
						PushNotificationHelper::send(NotificationEnum::NOTIFICATION_SEND_BY_ADMIN, $vendor_booking->vendor_id, $this->getMessage('booking_completed_success_title'), $this->getMessage('booking_completed_success_description'), NotificationEnum::VENDOR_JOB_FINISHED);
					}
				} catch (Exception $e) {
					// if payment is not completed then send the notification to vendor that payment is not settled 
					$booking_payment->payment_settled	= BookingEnum::PaymentNotSettled;
					$booking_payment->is_pending_payment	= BookingEnum::PaymentPending;
					// send push notification notification to vendor that payment not settled yet you get payment after few days
					PushNotificationHelper::send(NotificationEnum::NOTIFICATION_SEND_BY_ADMIN, $auth_vendor->id, $this->getMessage('vendor_payment_settled_title'), $this->getMessage('vendor_payment_settle_description'), NotificationEnum::VENDOR_JOB_FINISHED);
				}
				$booking_payment->save();
				// send push notification to the vendor
				PushNotificationHelper::send($auth_vendor->id, $vendor_booking->vendor_id, $this->getMessage('you_job_finished'), $this->getMessage('you_have_finished_job_description', ['service_name' => $vendor_booking->service->name]), NotificationEnum::VENDOR_JOB_FINISHED);
				// send push notification to the booking user
				PushNotificationHelper::send($auth_vendor->id, $vendor_booking->user_id, $this->getMessage('vendor_finished_job'), $this->getMessage('vendor_finished_job_description', ['service_name' => $vendor_booking->service->name]), NotificationEnum::VENDOR_JOB_FINISHED);
				return $this->getMessage('you_have_successfully_finished_the_job');
			}
		}


		// booking cancelled
		//! Both user and vendor can cancel the booking
		if ($request->booking_status == BookingEnum::bookingCancelled) {
			if ($auth_vendor->role == UserEnum::user_vendor) {
				$booking = $this->bookingRepository->cancelAvailableBooking(['vendor_id' => $auth_vendor->id, 'id' => $request->booking_id]);
			} else {
				$booking = $this->bookingRepository->cancelAvailableBooking(['user_id' => $auth_vendor->id, 'id' => $request->booking_id]);
			}
			if (!$booking)
				throw new RecordNotFoundException($this->getMessage('booking_not_found'));

			$booking_payment = $booking->booking_payment;
			// if vendor already started the job then vendor vendor can
			if ($booking->booking_status == BookingEnum::VendorStartedJob) {
				throw new BadRequestException($this->getMessage('vendor_already_started_the_job'));
			}
			//  check if booking already cancelled
			if ($booking->booking_status == BookingEnum::bookingCancelled) {
				throw new BadRequestException($this->getMessage('booking_already_cancelled'));
			}
			$booking->booking_status = BookingEnum::bookingCancelled;
			// ! have to uncomment the code
			$booking->cancel_reason = $request->cancel_reason;
			$booking->save();

			$time_zone = $this->validateTimeZone($request->header('time-zone'));
			$current_time = Carbon::now()->setTimezone($time_zone)->format('Y-m-d H:i:s');
			$booking_date_difference_in_hours = (Carbon::parse($booking->booking_start_time)->diffInMinutes($current_time) / 60);
			// if user cancel the booking within 2 hour and if this booking is cancelled by vendor then we have to refund whole amount
			$is_full_refund = true;
			if ($auth_vendor->role == UserEnum::user_customer and $booking_date_difference_in_hours < BookingEnum::MinimumBookingTimeForRefundInHours) {
				$refund_amount = $this->calculateRefundPayment($booking_payment);
				$is_full_refund = false;
			} else {
				// refund full amount to the customer
				$refund_amount = $booking_payment->via_wallet + $booking_payment->total_amount_paid;
			}
			$booking_payment->refund_amount = $refund_amount;
			$refund = $this->refundPayment($booking_payment, $booking, $is_full_refund, $refund_amount);
			if ($refund) {
				$booking_payment->is_refunded = BookingEnum::PaymentRefunded;
				$booking_payment->payment_settled = BookingEnum::PaymentSettled;
			} else {
				$booking_payment->is_refunded = BookingEnum::PaymentRefunded;
				$booking_payment->is_pending_payment	= BookingEnum::PaymentPending;
				$booking_payment->payment_settled = BookingEnum::PaymentNotSettled;
			}
			$booking_payment->push();
			$booking->booking_status_history()->create(['booking_status' => BookingEnum::bookingCancelled]);
			// check who cancelled the booking
			$service_name = $booking->service->name;
			if ($auth_vendor->role == UserEnum::user_vendor) {
				// send push notification to the both user and vendor
				$this->sendCancelBookingPushNotificationToUser($booking->user_id, $booking->vendor_id, $service_name, $this->getMessage('vendor_cancelled_job_description', ['service_name' => $service_name]));
				$this->sendCancelBookingPushNotificationToVendor($booking->vendor_id, $booking->user_id, $service_name, $this->getMessage('you_have_successfully_cancelled_booking', ['service_name' => $service_name]));
			} else {
				$this->sendCancelBookingPushNotificationToVendor($booking->vendor_id, $booking->user_id, $service_name, $this->getMessage('booking_notification_description_for_vendor', ['service_name' => $service_name]));
				$this->sendCancelBookingPushNotificationToUser($booking->user_id, $booking->vendor_id, $service_name, $this->getMessage('you_have_successfully_cancelled_booking', ['service_name' => $service_name]));
			}
			return $this->getMessage('cancel_successful');
		}
		throw new BadRequestException($this->getMessage('invalid_move'));
	}

	public function getVendorLocation(GetVendorLocationRequest $request)
	{
		$vendor = $this->authUserRepository->get_user(['id' => $request->vendor_id]);
		if (!$vendor->vendor_locations) {
			throw new BadRequestException($this->getMessage('vendor_location_not_found'));
		}
		return [
			'latitude' => $vendor->vendor_locations->latitude,
			'longitude' => $vendor->vendor_locations->longitude
		];
	}
	public function rescheduleBooking(RescheduleBookingRequest $request)
	{
		$auth_user = Auth::user();
		$user_booking = $this->bookingRepository->getBooking(['id' => $request->booking_id, 'user_id' => $auth_user->id]);
		if (!$user_booking)
			throw new RecordNotFoundException($this->getMessage('booking_not_found'));

		if ($user_booking->booking_status == BookingEnum::VendorAssignedOrVendorAccepted or $user_booking->booking_status == BookingEnum::BookingConfirmed) {
			$old_booking_time = $user_booking->booking_start_time;
			$time_zone = $this->validateTimeZone($request->header('time-zone'));
			$booking_date = date('Y-m-d H:i:s', strtotime($request->selected_date . ' ' . $request->selected_time));
			// check for date should be not less tha  the current time
			$current_time = Carbon::now()->setTimezone($time_zone)->format('Y-m-d H:i:s');
			$seconds = strtotime($booking_date) - strtotime($current_time);
			$booking_time_difference_in_hours = $seconds / 3600;
			if ($booking_time_difference_in_hours < BookingEnum::Maximum_time_difference_for_booking)
				throw new BadRequestException($this->getMessage('booking_time_should_be_greater_than_from_current_time'));
			// check if booking reschedule time is  less than a specified time then it will not reschedule service
			$booking_time_diff_in_hours = round(Carbon::parse($user_booking->booking_start_time)->diffInSeconds($current_time) / BookingEnum::SecondInOneHour, 2);
			if ($booking_time_diff_in_hours < BookingEnum::RescheduleMinimumTimeInHours) {
				throw new BadRequestException($this->getMessage('cannot_reschedule_this_booking_because_booking_just_ahead', ['value' => BookingEnum::RescheduleMinimumTimeInHours]));
			}
			$booking_vendor =	$this->authUserRepository->get_user(['id' => $user_booking->vendor_id]);

			$vendor_service = $booking_vendor->vendor_services()->where('service_id', $user_booking->service_id)->first();
			$get_bookings = $this->bookingRepository->checkVendorBookings([$booking_date], $user_booking->vendor_id, $vendor_service, $request->booking_id);
			if ($get_bookings)
				throw new RecordNotFoundException($this->getMessage('vendor_not_available_at_requested_time', ['value' => date('Y-m-d H:i:s', strtotime($request->selected_date . ' ' . $request->selected_time))]));

			// create reschedule api booking time
			$booking_start_time = date('Y-m-d H:i:s', strtotime($request->selected_date . ' ' . $request->selected_time));
			$booking_end_time =  BookingHelper::getEndTime($booking_start_time, $vendor_service->time);
			$user_booking->booking_start_time = $booking_start_time;
			$user_booking->booking_end_time = $booking_end_time;
			$user_booking->booking_status = BookingEnum::BookingConfirmed;
			$user_booking->save();
			$user_booking->booking_status_history()->create(['booking_status' => BookingEnum::BookingConfirmed]);

			PushNotificationHelper::send($auth_user->id, $user_booking->vendor_id, $this->getMessage('booking_rescheduled'), $this->getMessage('booking_rescheduled_description', ['user_name' => $auth_user->first_name, 'to' => $booking_start_time, 'from' => $old_booking_time]), NotificationEnum::BOOKING_RESCHEDULE_NOTIFICATION);

			return $this->getMessage('your_booking_rescheduled_success');
		} else {
			throw new BadRequestException($this->getMessage('cannot_reschedule_this_booking'));
		}
	}

	public function getAllCompletedBookings(VendorCompletedBookingRequest $vendorCompletedBookingRequest)
	{
		$auth_vendor = Auth::user();
		$vendor_booking = $this->bookingRepository->getAllCompletedBookings($auth_vendor, $vendorCompletedBookingRequest);
		if (!$vendor_booking->count() > 0)
			throw new RecordNotFoundException($this->getMessage('booking_not_found'));
		return $vendor_booking;
	}
}

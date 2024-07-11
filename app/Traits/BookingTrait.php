<?php

namespace App\Traits;

use App\Enum\BookingEnum;
use App\Enum\NotificationEnum;
use App\Enum\UserEnum;
use App\Exceptions\BadRequestException;
use App\Exceptions\RecordNotFoundException;
use App\Helpers\V1\PushNotificationHelper;
use Carbon\Carbon;
use DateTimeZone;

trait BookingTrait
{
	use LocationTrait;
	private function validateBookingRequest($booking_data, $payment_data, $auth_user, $time_zone)
	{
		// check if vendor connected to stripe or not
		$connected_vendor = $this->authUserRepository->checkVendor($booking_data['vendor_id']);
		if (!$connected_vendor) {
			throw new BadRequestException($this->getMessage('cannot_book_service_with_this_vendor'));
		}
		$vendor_service = $connected_vendor->vendor_services()->where('service_id', $booking_data['service_id'])->first();
		if (!$vendor_service)
			throw new BadRequestException($this->getMessage('vendor_not_provide_this_service'));

		// check bookings dates . Is they are valid or not it booking date is less than that of the minimum minimum time then we have to show the error to the users
		$booking_time_status = $this->validate_booking_time($booking_data['booking_details'], $time_zone);


		// check if vendor already booked of not
		$get_bookings = $this->bookingRepository->checkVendorBookings($this->getAllBookingsDates($booking_data['booking_details']), $booking_data['vendor_id'], $vendor_service);
		if ($get_bookings)
			throw new RecordNotFoundException($this->getMessage('vendor_not_available_at_requested_time', ['value' => $get_bookings]));

		// check use have enough amount in the wallet if he added
		if ($payment_data['via_wallet'] > 0) {
			if ($auth_user->wallet_money < $payment_data['via_wallet'])
				throw new BadRequestException($this->getMessage('insufficient_wallet_amount'));
		}

		return $vendor_service;
	}
	private function validate_booking_time($booking_data, $time_zone)
	{
		// timezone hack for app end 
		$time_zone =	$this->validateTimeZone($time_zone);
		// process booking time
		$current_local_time = Carbon::now();
		foreach ($booking_data as $booking_time) {
			$booking_time = $booking_time['date'] . ' ' . $booking_time['time'];
			$current_time = $current_local_time->setTimezone($time_zone)->format('Y-m-d H:i:s');
			$seconds = strtotime($booking_time) - strtotime($current_time);
			$booking_time_difference_in_hours = $seconds / 3600;
			if ($booking_time_difference_in_hours < BookingEnum::Maximum_time_difference_for_booking)
				throw new BadRequestException($this->getMessage('booking_time_should_be_greater_than_from_current_time'));
		}
		return true;
	}

	public function validateTimeZone($time_zone)
	{
		if (!is_null($time_zone) and $time_zone == 'Asia/Calcutta')
			$time_zone = 'Asia/Kolkata';
		if (is_null($time_zone) or !in_array($time_zone, DateTimeZone::listIdentifiers())) {
			throw new BadRequestException($this->getMessage('invalid_time_zone'));
		}
		return $time_zone;
	}

	private function getAllBookingsDates(array $booking_details)
	{
		$date_time_response = [];
		foreach ($booking_details as $details) {
			$date_time_response[] = date('Y-m-d H:i:s', strtotime($details['date'] . ' ' . $details['time']));
		}
		return $date_time_response;
	}


	private function calculateRefundPayment($booking_payment)
	{

		return round(($booking_payment->via_wallet + $booking_payment->total_amount_paid) / 2, 2);
	}

	public function refundPayment($booking_payment, $booking, $is_full_refund, $refund_amount = null)
	{
		// !refund wallet amount
		if ($booking_payment->via_wallet > 0) {
			$booking_user = $this->authUserRepository->find($booking->user_id);
			if (!$booking_user)
				return false;
			$booking_user->wallet_money = $booking_user->wallet_money + $refund_amount;
			$booking_user->save();
			$refund_status = true;
		} else if ($is_full_refund) {
			$refund_status = $this->stripePayment->refund_payment($booking_payment->id);
		} else {
			$refund_status = $this->stripePayment->refund_payment($booking_payment->id, $refund_amount);
		}
		return $refund_status;
	}

	private function sendCancelBookingPushNotificationToVendor($send_to, $send_by, $service_name, $description_message)
	{
		$notification_title = $this->getMessage('booking_cancelled_title');
		PushNotificationHelper::send($send_by, $send_to, $notification_title, $description_message, NotificationEnum::BOOKING_CANCELLED);
	}
	private function sendCancelBookingPushNotificationToUser($send_to, $send_by, $service_name, $description_message)
	{
		$notification_title = $this->getMessage('booking_cancelled_title');
		PushNotificationHelper::send($send_by, $send_to, $notification_title, $description_message, NotificationEnum::BOOKING_CANCELLED);
	}

	private function geAdminNearShopToVendor($booking)
	{
		if (!$booking->booking_vendor) {
			return false;
		}
		$vendor_all_address = $booking->booking_vendor->user_verified_address;
		if (!$vendor_all_address->count() > 0)
			return false;

		$vendor_address = 	$vendor_all_address->where('type', UserEnum::USER_OFFICE_ADDRESS)->first();
		if (!$vendor_address) {
			$vendor_address = $vendor_all_address->where('type', UserEnum::USER_HOME_ADDRESS)->first();
			if (!$vendor_address) {
				return false;
			}
		}
		// this function defined inside of the LocationTrait
		$near_shops = $this->getShopWithInLocation($vendor_address->latitude, $vendor_address->longitude);
		if (!$near_shops)
			return false;
		return $near_shops;
	}
}

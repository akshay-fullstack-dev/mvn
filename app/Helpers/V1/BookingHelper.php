<?php

namespace App\Helpers\V1;

use App\Enum\BookingEnum;
use Carbon\Carbon;


class BookingHelper
{

	public static function getBookingData($request)
	{
		$response_data = [
			'booking_type' => $request->booking_type,
			'vendor_id' => $request->vendor_id ?? null,
			'address_id' => $request->address_id,
			'service_id' => $request->service_id,
			'package_id' => ($request->package_id == null or $request->package_id == 0 or $request->package_id == "") ? BookingEnum::NormalBooking : $request->package_id,
			'booking_details' => [],

		];
		$booking_request_details = [];
		$index = 0;
		foreach ($request->booking_details as $booking_details) {
			$booking_request_details[$index] = [
				'vehicle_id' => $booking_details['vehicle_id'],
				'date' => $booking_details['date'],
				'time' => $booking_details['time'],
				'additional_info' => $booking_details['additional_info'] ?? "",
			];
		}
		$response_data['booking_details'] = $booking_request_details;
		return $response_data;
	}
	public static function packageMaintain($user_id, $package_id, $order_id, $transaction_id, $amount): array
	{

		return [
			"package_id" => $package_id,
			"user_id" => $user_id,
			"order_id" => $order_id,
			"transaction_id" => $transaction_id,
			"amount" => $amount
		];
	}

	public static function getPaymentData($request): array
	{

		$payment_data = $request->payment_details;
		return [
			"card_token" => $payment_data['card_id'] ?? null,
			"currency_code" => $payment_data['currency_code'] ?? null,
			"total_amount" => $payment_data['total_amount'],
			"total_amount_paid" => round($payment_data['total_amount_paid'], 2),
			"delivery_charges" => round($payment_data['delivery_charges'], 2),
			"booking_distance" => round($payment_data['booking_distance'], 2),
			"basic_service_charge" => $payment_data['basic_service_charge'],
			"via_wallet" => $payment_data['via_wallet'] ?? 0,
			'coupon_id' => $payment_data['coupon_details']['coupon_id'] ?? null,
			'coupon_discount_amount' => $payment_data['coupon_details']['discount_amount'] ?? null,
			'spare_part_price' => $payment_data['spare_part_price'] ?? 0
		];
	}

	public static function getPackagePaymentData($request): array
	{

		$payment_data = $request->payment_details;
		return [
			"card_token" => $payment_data['card_id'] ?? null,
			"currency_code" => $payment_data['currency_code'] ?? null,
			"total_amount" => $payment_data['total_amount'],
			"total_amount_paid" => round($payment_data['total_amount_paid'], 2),

			"via_wallet" => $payment_data['via_wallet'] ?? 0,
			'coupon_id' => $payment_data['coupon_details']['coupon_id'] ?? null,
			'coupon_discount_amount' => $payment_data['coupon_details']['discount_amount'] ?? null,
			'spare_part_price' => $payment_data['spare_part_price'] ?? 0
		];
	}



	public static function insertBookingPaymentData($payment_data, $vendor_admin_booking_split): array
	{


		return [
			'coupon_id' => $payment_data['coupon_id'],
			'amount_paid' => BookingEnum::BooingAmountPaid,
			'total_amount' => $payment_data['total_amount'],
			'total_amount_paid' => $payment_data['total_amount_paid'],
			'currency_code' => $payment_data['currency_code'],
			'delivery_charges' => $payment_data['delivery_charges'],
			'basic_service_charge' => $payment_data['basic_service_charge'],
			'via_wallet' => $payment_data['via_wallet'],
			'discount_amount' => $payment_data['coupon_discount_amount'],
			'basic_service_charge_received_by_admin' => $vendor_admin_booking_split['admin_service_charge'],
			'basic_service_charge_received_by_vendor' => $vendor_admin_booking_split['vendor_service_charge'],
			'delivery_charge_received_by_admin' => $vendor_admin_booking_split['admin_delivery_charge'],
			'delivery_charge_received_by_vendor' => $vendor_admin_booking_split['vendor_delivery_charge'],
			'spare_part_price' => $payment_data['spare_part_price']
		];
	}
	public static function insertBookingPackageData($payment_data, $vendor_admin_booking_split): array
	{
		//  dd($maintenance);
		return [
			'coupon_id' => $payment_data['coupon_id'],
			'amount_paid' => BookingEnum::BooingAmountPaid,
			'total_amount' => $payment_data['total_amount'],
			'total_amount_paid' => $payment_data['total_amount_paid'],
			'currency_code' => $payment_data['currency_code'],
			'via_wallet' => $payment_data['via_wallet'],
			'discount_amount' => $payment_data['coupon_discount_amount'],
			'basic_service_charge_received_by_admin' => $vendor_admin_booking_split['admin_service_charge'],
			'basic_service_charge_received_by_vendor' => $vendor_admin_booking_split['vendor_service_charge'],
			'delivery_charge_received_by_admin' => BookingEnum::FREE_DELIVERY_FOR_PACKAGE,
			'delivery_charge_received_by_vendor' => BookingEnum::FREE_DELIVERY_FOR_PACKAGE,
			'spare_part_price' => $payment_data['spare_part_price']
		];
	}
	public static function getEndTime($booking_start_time, $service_time)
	{
		$booking_start_in_sec = strtotime($booking_start_time);

		$booking_time = strtotime($service_time) - strtotime('00:00:00');
		// echo ' ' . date('H:i:s', strtotime($service_time));
		return  date('Y-m-d H:i:s', $booking_time + $booking_start_in_sec);
	}
	public static function getBookingInsertData($user_id, array $booking_data, $order_id, $validated_service, $payment_id)
	{
		$booking_type = BookingEnum::NormalBooking;
		if ($booking_data['package_id'] != null) {
			$booking_type = BookingEnum::PackageBooking;
		}
		$booking_insert_data = [];
		foreach ($booking_data['booking_details'] as $data) {
			// calculate booking start and end time
			$booking_start_time = date('Y-m-d H:i:s', strtotime($data['date'] . ' ' . $data['time']));
			$booking_end_time =  self::getEndTime($booking_start_time, $validated_service->time);

			$booking_insert_data[] = [
				'order_id' => $order_id,
				'user_id' => $user_id,
				'vendor_id' => $booking_data['vendor_id'],
				'service_id' => $booking_data['service_id'],
				'address_id' => $booking_data['address_id'],
				'package_id' => $booking_data['package_id'],
				'vehicle_id' => $data['vehicle_id'],
				'payment_id' => $payment_id,
				'booking_status' => BookingEnum::BookingConfirmed,
				'booking_type' => $booking_type,
				'booking_start_time' => $booking_start_time,
				'booking_end_time' => $booking_end_time,
				'addition_info' => $data['additional_info'] ?? "",
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			];
		}
		return $booking_insert_data;
	}



	public static function getPackageBookingInsertData($user_id, array $booking_data, $order_id, $payment_id, $packageServices)
	{
		$booking_type = BookingEnum::PackageBooking;
		$vendor_id = NULL;
		$bookingsData = [];
		foreach ($packageServices as $packageService) {
			$booking_insert_data = [];
			foreach ($booking_data['booking_details'] as $data) {
				// calculate booking start and end time
				$booking_start_time = date('Y-m-d H:i:s', strtotime($data['date'] . ' ' . $data['time']));
				$booking_end_time =  self::getEndTime($booking_start_time, $data['time']);

				$booking_insert_data = [
					'order_id' => $order_id,
					'user_id' => $user_id,
					'vendor_id' => $vendor_id,
					'service_id' => $packageService->id,
					'address_id' => $booking_data['address_id'],
					'package_id' => $booking_data['package_id'],
					'vehicle_id' => $data['vehicle_id'],
					'payment_id' => $payment_id,
					'booking_status' => BookingEnum::BookingConfirmed,
					'booking_type' => $booking_type,
					'booking_start_time' => $booking_start_time,
					'booking_end_time' => $booking_end_time,
					'addition_info' => $data['additional_info'] ?? "",
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				];
			}
			array_push($bookingsData, $booking_insert_data);
		}
		return $bookingsData;
	}
	public static function processBookingPrice($payment_data, $delivery_charge)
	{

		$total_booking_charge = $payment_data['total_amount_paid'] + $payment_data['via_wallet'];

		// split Booking price
		$service_charges = $total_booking_charge - $payment_data['delivery_charges'] - $payment_data['spare_part_price'];

		// vendor amount should not be calculated in the basis of the wallet amount
		// wallet amount is credited from the vendor account
		// coupon discount amount is
		$admin_commission = $service_charges * (BookingEnum::AdminBookingCommission / 100);

		$vendor_price = $service_charges - $admin_commission;
		$amount_received_by_admin = $admin_commission - $payment_data['via_wallet'];
		// split booking delivery charge
		$vendor_delivery_charge = $payment_data['booking_distance'] * $delivery_charge->vendor_delivery_charge;
		$admin_delivery_charge =  $payment_data['delivery_charges'] - ($payment_data['booking_distance'] * $delivery_charge->vendor_delivery_charge);

		return [
			'admin_service_charge' => $amount_received_by_admin,
			'admin_delivery_charge' => $admin_delivery_charge,
			'vendor_service_charge' => $vendor_price,
			'vendor_delivery_charge' => $vendor_delivery_charge,
		];
	}


	static function processBookingPaymentPackage($payment_data, $total_services)
	{
		$total_booking_charge = $payment_data['total_amount_paid'] + $payment_data['via_wallet'];
		$admin_commission = $total_booking_charge * (BookingEnum::AdminBookingCommission / 100);
		$vendor_price = $total_booking_charge - $admin_commission;
		$amount_received_by_admin = $admin_commission - $payment_data['via_wallet'];
		return [
			'admin_service_charge' => $amount_received_by_admin,
			// 'admin_delivery_charge' => $admin_delivery_charge,
			'vendor_service_charge' => $vendor_price/$total_services,
			// 'vendor_delivery_charge' => $vendor_delivery_charge,
		];
	}
}

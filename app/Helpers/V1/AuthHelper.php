<?php

namespace App\Helpers\V1;

use App\Enum\UserEnum;

trait AuthHelper
{

	public static function get_register_login_data($request)
	{
		return [
			// required field
			'email' => strtolower($request->email),
			'first_name' => $request->first_name,
			'last_name' => $request->last_name,
			'phone_number' => $request->phone_number,
			'country_iso_code' => $request->country_iso_code,
			'country_code' => $request->country_code,
			'is_blocked' => UserEnum::not_blocked,
			'account_status' => UserEnum::no_action,
			'admin_user' => UserEnum::no_admin_user,
			'role' => UserEnum::user_vendor,
			'login_type' => UserEnum::NORMAL_LOGIN
		];
	}
	public static function getUserTempData($request_user_data, $user_id)
	{
		return [
			'first_name' => $request_user_data->first_name,
			'last_name' => $request_user_data->last_name,
			'user_id' => $user_id
		];
	}

	public static function getInsertUserAddressData($address_data, $user_id)
	{
		$returnData = [];
		foreach ($address_data as $singleAddress) {
			$returnData[] = [
				'user_id' => $user_id,
				'type' => $singleAddress['type'],
				'latitude' => $singleAddress['latitude'],
				'longitude' => $singleAddress['longitude'],
				// optional perimeters
				'house_no' => $singleAddress['house_no'] ?? "",
				'state' => $singleAddress['state'] ?? "",
				'zip_code' => $singleAddress['zip_code'] ?? "",
				'city' => $singleAddress['city'] ?? "",
				'country' => $singleAddress['country'] ?? "",
				'formatted_address' => $singleAddress['formatted_address'] ?? "",
				'additional_info' => $singleAddress['additional_info'] ?? "",
			];
		}
		return $returnData;
	}

	public static function getUserUpdateData($request)
	{
		$return_data = array();
		if ($request->first_name)
			$return_data['first_name'] = $request->first_name;
		if ($request->last_name)
			$return_data['last_name'] = $request->last_name;
		return $return_data;
	}

	public static function getUserAddressUpdateData($address_data)
	{
		$returnData = [];
		foreach ($address_data as $singleAddress) {
			$returnData[] = [
				'type' => $singleAddress['type'],
				'latitude' => $singleAddress['latitude'],
				'longitude' => $singleAddress['longitude'],
				'city' => $singleAddress['city'] ?? "",
				'country' => $singleAddress['country'] ?? "",
				'formatted_address' => $singleAddress['formatted_address'] ?? "",
				'additional_info' => $singleAddress['additional_info'] ?? "",
			];
		}

		//! insert and update pending
		return $returnData;
	}
	public static function sendStaticOtp($phone_number): bool
	{
		$static_otp_number = ['+12025550849', '+12025550191', '+17316607416'];
		if (in_array($phone_number, $static_otp_number))
			return true;
		return false;
	}

	public static function getSocialLoginData($request)
	{
		return [
			// required fields
			'login_type' => $request->login_type,
			'social_id' => $request->social_id,
			// optional field
			'email' => strtolower($request->email) ?? "",
			'first_name' => $request->first_name ?? "",
			'last_name' => $request->last_name ?? "",
			'phone_number' => $request->phone_number ?? "",
			'profile_picture' => $request->profile_picture ?? "",
			'admin_user' => UserEnum::no_admin_user,
			'role' => UserEnum::user_customer,
			'is_blocked' => UserEnum::not_blocked,
			'account_status' => UserEnum::user_verified,
			'is_offline' => UserEnum::online
		];
	}

	public static function get_insert_update_data($request, array $additional_data = [])
	{
		$return_data = array();
		if (isset($request->first_name)) {
			$return_data['first_name'] = $request->first_name;
		}
		if (isset($request->last_name)) {
			$return_data['last_name'] = $request->last_name;
		}
		if (isset($request->email)) {
			$return_data['email'] = strtolower($request->email);
		}
		if (isset($request->social_id)) {
			$return_data['social_id'] = $request->social_id;
		}
		if (isset($request->phone_number)) {
			$return_data['phone_number'] = $request->phone_number;
		}
		if (isset($request->profile_picture)) {
			$return_data['profile_picture'] = $request->profile_picture;
		}
		if (isset($request->country_iso_code)) {
			$return_data['country_iso_code'] = $request->country_iso_code;
		}
		if (isset($request->country_code)) {
			$return_data['country_code'] = $request->country_code;
		}
		$constant_data = [
			'admin_user' => UserEnum::no_admin_user,
			'role' => UserEnum::user_customer,
			'is_blocked' => UserEnum::not_blocked,
			'account_status' => UserEnum::user_verified,
			'is_offline' => UserEnum::online,
			'login_type' => UserEnum::NORMAL_LOGIN
		];
		return	array_merge($additional_data, array_merge($constant_data, $return_data));
	}

	public static function getUpdateAddress($address)
	{
		return $returnData[] = [
			'type' => $address['type'],
			'latitude' => $address['latitude'],
			'longitude' => $address['longitude'],
			'city' => $address['city'] ?? "",
			'country' => $address['country'] ?? "",
			'formatted_address' => $address['formatted_address'] ?? "",
			'additional_info' => $address['additional_info'] ?? "",
		];
	}

	public static function getInsertAddress($address, $user_id)
	{
		return $returnData[] = [
			'type' => $address['type'],
			'latitude' => $address['latitude'],
			'longitude' => $address['longitude'],
			// optional parameters
			'house_no' => $address['house_no'] ?? "",
			'state' => $address['state'] ?? "",
			'zip_code' => $address['zip_code'] ?? "",
			'city' => $address['city'] ?? "",
			'country' => $address['country'] ?? "",
			'formatted_address' => $address['formatted_address'] ?? "",
			'additional_info' => $address['additional_info'] ?? "",
		];
	}
}

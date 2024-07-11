<?php

namespace App\Helpers\V1;

use App\Enum\DeviceTypeEnum;
use App\Enum\UserEnum;
use App\Models\DeviceDetail;
use App\Models\Notification;
use App\User;

class PushNotificationHelper
{
	public static function send($user_id, $send_to_user_id, $title, $message, $notification_type, $insert_record = true)
	{
		$additional_data = ['notification_type' => $notification_type, 'sender_id' => $user_id];
		$status = self::sendNotification($send_to_user_id, $title, $message, $additional_data);
		if ($status) {
			// check the we have to save record or not
			if ($insert_record)
				self::saveNotification($user_id, $send_to_user_id, $title, $message, $notification_type);
			return true;
		}
		return false;
	}


	private static function sendNotification($send_to_user_id, $title, $message, array $additional_data = [])
	{
		$deviceTokens = DeviceDetail::where('user_id', $send_to_user_id)->get();

		if ($deviceTokens->count() == 0) {
			return false;
		}

		$send_to_user = User::where('id', $send_to_user_id)->first();
		// set fcm server key 
		$fcm_server_key = env('FCM_SERVER_CLIENT_SIDE_KEY');
		if ($send_to_user->role == UserEnum::user_vendor)
			$fcm_server_key = env('FCM_SERVER_VENDOR_SIDE_KEY');
		$ios_token = [];
		$android_token = [];
		foreach ($deviceTokens as $deviceToken) {
			if ($deviceToken['platform'] == DeviceTypeEnum::ios) {
				$ios_token[] = $deviceToken['device_token'];
			} else {
				$android_token[] = $deviceToken['device_token'];
			}
		}
		$return_data = 0;
		// crate ios data
		if (count($ios_token) > 0) {
			$notification = [
				'title' => $title,
				'sound' => "default",
				'body' => $message,
				'content_available' => true,
				'priority' => "high",
			];
			$notification_data = [
				'sound' => "default",
				'body' => $message,
				'title' => $title,
				'notification_type' =>  $additional_data['notification_type'],
				'content_available' => true,
				'priority' => "high",
			];
			$fcm_notification = [
				'registration_ids' => $android_token, //multiple token array
				"notification" => $notification,
				'data' => $notification_data
			];
			$return_data = self::send_request_to_fcm_server($fcm_notification, $fcm_server_key);
		}
		// create android data
		if (count($android_token) > 0) {
			$notification = [
				'title' => $title,
				'sound' => "default",
				'body' => $message,
				'content_available' => true,
				'priority' => "high",
			];
			$notification_data = [
				'sound' => "default",
				'body' => $message,
				'title' => $title,
				'notification_type' =>  $additional_data['notification_type'],
				'content_available' => true,
				'priority' => "high",
			];
			$fcm_notification = [
				'registration_ids' => $android_token, //multiple token array
				"notification" => $notification,
				'data' => $notification_data
			];
			$return_data = self::send_request_to_fcm_server($fcm_notification, $fcm_server_key);
		}
		if (!$return_data)
			// if nothing is found return false
			return false;
		return true;
	}

	// send push notification data to google fcm server
	private static function send_request_to_fcm_server(array $fcm_notification_data, $fcm_server_key)
	{
		$fcmUrl = 'https://fcm.googleapis.com/fcm/send';

		$headers = [
			'Authorization: key=' . $fcm_server_key,
			'Content-Type: application/json',
			'Accept: application/json'
		];

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $fcmUrl);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcm_notification_data));
		$result = curl_exec($ch);
		if ($result) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	// thi function is us
	private static function saveNotification($user_id, $send_to_user_id, $title, $message, $notification_type)
	{
		return	Notification::create([
			'send_by' => $user_id,
			'send_to' => $send_to_user_id,
			'notification_type' => $notification_type,
			'title' => $title,
			'description' => $message,
			'is_read' => false
		]);
	}
}

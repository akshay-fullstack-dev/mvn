<?php

namespace App\Services;

use App\Enum\OtpEnum;
use App\Exceptions\BadRequestException;
use App\Helpers\V1\AuthHelper;
use App\Mail\EmailOtpSend;
use App\Models\UserOtp;
use Illuminate\Support\Facades\Mail;
use App\Repositories\Interfaces\IOtpRepository;
use App\User;
use Carbon\Carbon;
use Twilio\Exceptions\RestException;
use Twilio\Rest\Client;
use App\Services\Interfaces\IOtpService;
use App\Repositories\OtpRepository;

class OtpServices implements IOtpService
{
	private $otpRepo;


	public function __construct(IOtpRepository $otpRepo)
	{
		$this->otpRepo = $otpRepo;
	}

	public  function get_otp()
	{
		return $this->get_random_otp();
	}

	private  function get_static_otp()
	{
		return 666666;
	}
	private  function get_random_otp()
	{
		return random_int(100000, 999999);
	}

	public function send_otp($country_code, $phone_number)
	{
		$full_number = $country_code . '' . $phone_number;
		$is_static_number = AuthHelper::sendStaticOtp($full_number);
		// get the otp on the basis of the static number
		if ($is_static_number or (env('APP_ENVIRONMENT') == 'local')) {
			$otp = $this->get_static_otp();
		} else {
			$otp = $this->get_otp();
			if (!$this->send_otp_using_twilio($country_code, $phone_number, $otp))
				return false;
		}
		return $this->save_phone_otp($otp, $country_code, $phone_number);
	}

	// This function is called from the auth service to send the email otp
	public function send_email_otp($email)
	{
		$otp = $this->get_random_otp();
		Mail::to($email)->send(new EmailOtpSend($email, $otp));
		if (Mail::failures())
			return false;

		$insert_ot_data = $this->save_email_otp($otp, $email);
		if (!$insert_ot_data)
			return false;
		return true;
	}

	private function save_email_otp($otp, $email)
	{
		// delete old otp
		$data = $this->otpRepo->get_old(['email' => $email]);
		if ($data != null) {
			$data->delete();
		}
		$otp_expire_time = Carbon::now()->addRealMinutes(OtpEnum::expire_time_in_minutes);
		return  $this->otpRepo->create($this->save_otp_data($otp, $otp_expire_time, $email));
	}

	private function save_phone_otp($otp, $country_code, $phone_number)
	{
		// delete old otp
		$data = $this->otpRepo->get_old(['phone_number' => $phone_number]);
		if ($data != null) {
			$data->delete();
		}
		$otp_expire_time = Carbon::now()->addRealMinutes(OtpEnum::expire_time_in_minutes);
		return  $this->otpRepo->create($this->save_otp_data($otp, $otp_expire_time, $email = "", $country_code, $phone_number));
	}
	// this function is called from save otp function
	private function save_otp_data($otp, $otp_expire_time, $email = "", $country_code = "", $phone_number = "")
	{
		return [
			'email' => strtolower($email),
			'country_code' => $country_code,
			'phone_number' =>  $phone_number,
			'otp' =>  $otp,
			'expired_at' =>  $otp_expire_time,
		];
	}


	// twilio section started
	private function send_otp_using_twilio($country_code, $phone_number, $otp_code)
	{
		$account_sid = env('TWILIO_SID');
		$auth_token = env('TWILIO_TOKEN');
		$twilio_sms_from_number = env('TWILIO_SMS_FROM_NUMBER');
		$client = new Client($account_sid, $auth_token);
		$receiver_number = $country_code . "" . $phone_number;
		try {
			$status = $client->messages->create(
				// Where to send a text message (your cell phone?)
				$receiver_number,
				array(
					'from' => $twilio_sms_from_number,
					'body' => trans('Api/v1/twilio.twilio_send_message', ['app_name' => env('APP_NAME'), 'otp_code' => $otp_code])
				)
			);
		} catch (RestException $ex) {
			$message = $this->getTwilioMessage($ex->getMessage());
			throw new	BadRequestException($message);
		}
		if ($status) {
			return true;
		}
		return false;
	}

	private function getTwilioMessage($message = '')
	{
		if ($message == '') {
			return trans('Api/v1/auth.cannot_sed_the_message_on_this_number');
		} else {
			$array_message = explode(':', $message);
			if (isset($array_message[2]))
				return $array_message[2];
			else
				return trans('Api/v1/auth.cannot_sed_the_message_on_this_number');
		}
	}

	public function verify_otp($otp_code, $phone_number, $country_code)
	{
		$otp = $this->otpRepo->where(['phone_number' => $phone_number, 'otp' => $otp_code, 'country_code' => $country_code])->first();
		if ($otp) {
			$otp->delete();
			return $otp;
		}
		return false;
	}

	public function verify_email_otp($email, $otp)
	{
		$otp = $this->otpRepo->where(['email' => $email, 'otp' => $otp])->first();
		if ($otp) {
			$otp->delete();
			return 	$otp;
		}
		return false;
	}
}

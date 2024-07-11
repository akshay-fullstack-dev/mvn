<?php 
namespace App\Helpers;
use App\Exceptions\BadRequestException;
use Twilio\Exceptions\RestException;
use Twilio\Rest\Client;
use Mailjet\LaravelMailjet\Facades\Mailjet;
class OtpHelper {
   public static function get_otp()
   {
    return self::get_random_otp();
   }
   private static function get_random_otp()
   {
		 return	random_int(100000, 999999);
   }
   public static function send_otp($phone_number, $otp_code)
   {
      return self::send_otp_using_twilio($phone_number, $otp_code);
   }
   private static function send_otp_using_twilio($phone_number, $otp_code)
	{ 
		$account_sid = env('TWILIO_SID');
		$auth_token = env('TWILIO_TOKEN');
		$twilio_sms_from_number = env('TWILIO_SMS_FROM_NUMBER');
		$client = new Client($account_sid, $auth_token);
		/* try { */
			$status = $client->messages->create(
				// Where to send a text message (your cell phone?)
				$phone_number,
				array(
					'from' => $twilio_sms_from_number,
					'body' => "Your OTP for " . env('APP_NAME') . ' is :- ' . $otp_code
				)
			);
		/* } catch (RestException $ex) {
			
			$message = self::getTwilioMessage($ex->getMessage());
			throw new	BadRequestException($message);
		} */
		if ($status) {
			return true;
		}
		return false;
	}

	private static function getTwilioMessage($message = '')
	{
		if ($message == '') {
			return trans('Api/v1/auth.cannot_sed_the_message_on_this_number');
		} else {
			$array_message = explode(':', $message);
			if (isset($array_message[1]))
				return $array_message[1];
			else
				return trans('Api/v1/auth.cannot_sed_the_message_on_this_number');
		}
	}




	public static function send_otp_email($email, $otp_code)
	{
	   return self::send_otp_using_mailjet($email, $otp_code);
	}
	public static function send_otp_using_mailjet($email, $otp_code)
	{
	// Use your saved credentials, specify that you are using Send API v3.1
	$mj = new \Mailjet\Client(getenv('MJ_APIKEY_PUBLIC'), getenv('MJ_APIKEY_PRIVATE'),true,['version' => 'v3.1']);

	// Define your request body

	$body = [
    'Messages' => [
        [
            'From' => [
                'Email' => "aipl@gmail.com",
                'Name' => "Me"
            ],
            'To' => [
                [
                    'Email' => "$email",
                    'Name' => "You"
                ]
            ],
            'Subject' => "My first Mailjet Email!",
            'TextPart' => "Greetings from Mailjet!",
            'HTMLPart' => "<h3>Dear passenger 1, welcome to <a href=\"https://www.mailjet.com/\">Mailjet</a>!</h3>
            <br />May the delivery force be with you!"
        ]
    ]
];

// All resources are located in the Resources class

$response = $mj->post(Resources::$Email, ['body' => $body]);

// Read the response

$response->success() && var_dump($response->getData());
}
}

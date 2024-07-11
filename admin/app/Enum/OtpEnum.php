<?php

namespace App\Enum;

class OtpEnum
{
	// send type
	const sendEmail = 1;
	const sendPhoneNumber = 0;
	const sendEmailPhoneNumber = 2;

	const expire_time_in_minutes = 10;

	// login type
	const login_response = 1;
	const verify_otp = 2;
}

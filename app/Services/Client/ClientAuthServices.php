<?php

namespace App\Services\Client;

use App\Enum\CommonEnum;
use App\Enum\NotificationEnum;
use App\Enum\UserEnum;
use App\Exceptions\BadRequestException;
use App\Exceptions\RecordNotFoundException;
use App\Helpers\V1\AuthHelper;
use App\Helpers\V1\CurrencyHelper;
use App\Helpers\V1\GeneralHelper;
use App\Helpers\V1\PushNotificationHelper;
use App\Http\Requests\V1\ClientRequests\Auth as AuthRequest;
use App\Repositories\Interfaces as Repository;
use App\Services\Interfaces\Client as ClientService;
use App\Services\Interfaces as ServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClientAuthServices implements ClientService\IClientAuthService
{

	private $authUserRepository;
	private $otpService;
	private $deviceService;
	private $referralRepository;
	public function __construct(
		ServiceInterface\IOtpService $otpService,
		ServiceInterface\IDeviceService $deviceService,
		Repository\IAuthUserRepository $authUserRepository,
		ServiceInterface\ICouponServices $couponService,
		Repository\IReferralPriceRepository $referralRepository
	) {
		$this->authUserRepository = $authUserRepository;
		$this->deviceService = $deviceService;
		$this->otpService = $otpService;
		$this->couponService = $couponService;
		$this->referralRepository = $referralRepository;
	}
	public function socialLogin(AuthRequest\SocialLoginRequest $request)
	{
		$data = AuthHelper::getSocialLoginData($request);
		$user = $this->authUserRepository->get_user(['social_id' => $request->social_id, 'login_type' =>  $request->login_type]);
		// if user exist then update its values
		if (!$user) {
			$user = $this->authUserRepository->create($data);
		}
		$user->access_token = $user->createToken('Api access token')->accessToken;
		// save device details
		$this->deviceService->saveDeviceDetail($user->id);
		return $user;
	}

	// public function create user
	public function register(AuthRequest\CreateUserRequest $request)
	{
		$user_exist = $this->authUserRepository->get_user(['email' => strtolower($request->email)]);
		if ($user_exist)
			throw new BadRequestException(trans('Api/v1/auth.email_already_registered'));
		$user_exist = $this->authUserRepository->get_user(['country_code' => $request->country_code, 'phone_number' => $request->phone_number]);
		if ($user_exist)
			throw new BadRequestException(trans('Api/v1/auth.phone_number_already_registered'));

		$otp_send_status = $this->otpService->send_otp($request->country_code, $request->phone_number);
		if (!$otp_send_status)
			throw new BadRequestException(trans('Api/v1/auth.cannot_send_otp_please'));
		$additional_store_data = [
			'password' => Hash::make($request->password),
			'referral_code' => $this->getUserReferralCode()
		];

		$insert_data = AuthHelper::get_insert_update_data($request, $additional_store_data);
		$user = $this->authUserRepository->create($insert_data);
		// add coupons for both the users

		if ($request->referral_code and $request->referral_code != "") {
			$referral_amount_from_db = $this->referralRepository->get_referral_amount();
			$referral_amount = $referral_amount_from_db ? $referral_amount_from_db->referral_amount : CommonEnum::REFERRAL_COUPON_AMOUNT;
			$referred_by_user =  $this->authUserRepository->get_user(['referral_code' => $request->referral_code]);
			if ($referred_by_user) {
				$user->referral_by_user_id = $referred_by_user->id;
				$user->wallet_money = $referral_amount;
				$user->save();
				$referred_by_user->wallet_money = $referred_by_user->wallet_money + $referral_amount;
				$referred_by_user->save();
				PushNotificationHelper::send($user->id, $referred_by_user->id, trans('Api/v1/auth.referral_notification'), trans('Api/v1/auth.referral_notification_description', ['user_name' => $user->first_name, 'value' => CurrencyHelper::format_currency_us_local($referral_amount)]), NotificationEnum::REFERRAL_USER_NOTIFICATION);
			}
		}
		$user->access_token = $user->createToken('Api access token')->accessToken;
		return $user;
	}

	private function getUserReferralCode()
	{
		while (true) {
			$user_referral_code =	GeneralHelper::getReferralCode();
			$user_exist = $this->authUserRepository->get_user(['referral_code' => $user_referral_code]);
			if (!$user_exist) {
				return $user_referral_code;
			}
		}
	}
	public function changePassword(AuthRequest\ChangePasswordRequest $request)
	{
		$user = Auth::user();
		if ($user->login_type != UserEnum::NORMAL_LOGIN)
			throw new  BadRequestException(trans('Api/v1/auth.you_cannot_change_your_password'));
		if (!Hash::check($request->old_password, $user->password))
			throw new  BadRequestException(trans('Api/v1/auth.old_password_not_correct'));
		$user->password = Hash::make($request->new_password);
		$user->save();
		return trans('Api/v1/auth.password_changed');
	}

	public function login(AuthRequest\LoginRequest $request)
	{
		$user = $this->authUserRepository->get_user(['email' => $request->email]);
		if (!$user)
			throw new RecordNotFoundException(trans('Api/v1/auth.user_not_exist'));
		if (!Hash::check($request->password, $user->password))
			throw new  BadRequestException(trans('Api/v1/auth.incorrect_email_or_password'));
		if ($user->login_type != UserEnum::NORMAL_LOGIN)
			throw new  BadRequestException(trans('Api/v1/auth.you_are_not_authorized_to_login'));
		if ($user->role != UserEnum::user_customer) {
			throw new RecordNotFoundException(trans('Api/v1/auth.user_not_found'));
		}
		$user->access_token = $user->createToken('Api access token')->accessToken;
		// save device details
		$this->deviceService->saveDeviceDetail($user->id);
		return $user;
	}

	public function forgotPassword(AuthRequest\ForgotPasswordRequest $request)
	{
		$user = $this->authUserRepository->get_user(['country_code' => $request->country_code, 'phone_number' => $request->phone_number]);
		if (!$user)
			throw new  BadRequestException(trans('Api/v1/auth.user_not_found'));

		if ($user->login_type != UserEnum::NORMAL_LOGIN)
			throw new  BadRequestException(trans('Api/v1/auth.you_cannot_change_your_password'));
		$user->password = Hash::make($request->password);
		$user->save();
		return trans('Api/v1/auth.password_changed');
	}
}

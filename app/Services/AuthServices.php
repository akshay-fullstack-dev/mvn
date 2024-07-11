<?php

namespace App\Services;

use App\Enum\NotificationEnum;
use Carbon\Carbon;
use App\Enum\OtpEnum;
use App\Enum\UserEnum;
use Illuminate\Http\Request;
use App\Helpers\V1\AuthHelper;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\BadRequestException;
use App\Exceptions\BlockedUserException;
use App\Services\Interfaces\IOtpService;
use App\Services\Interfaces\IAuthService;
use App\Exceptions\RecordNotFoundException;
use App\Helpers\V1\PushNotificationHelper;
use App\Services\Interfaces\IDeviceService;
use App\Http\Requests\V1\Auth\SendOtpRequest;
use App\Http\Requests\V1\Auth\VerifyOtpRequest;
use App\Http\Requests\V1\Auth\CreateUserRequest;
use App\Http\Requests\V1\Auth\ChangeEmailRequest;
use App\Http\Requests\V1\Auth\ChangeProfileRequest;
use App\Repositories\Interfaces\IAuthUserRepository;
use App\Repositories\Interfaces\ITempUserRepository;
use App\Http\Resources\v1\Auth\UserDocumentsResource;
use App\Http\Requests\V1\Auth\ChangePhoneNumberRequest;
use App\Http\Requests\V1\Auth\ChangeProfileImageRequest;
use App\Http\Requests\V1\Auth\CheckUserRequest;
use App\Http\Requests\V1\Auth\DeleteAddressRequest;
use App\Http\Requests\V1\Auth\LoginRequest;
use App\Http\Requests\V1\Auth\UpdateVendorLocationRequest;
use App\Http\Requests\V1\Auth\UploadUserDocumentRequest;
use App\Repositories\Interfaces\IUserDocumentRepository;
use App\Repositories\Interfaces\ITempUserAddressRepository;
use App\Repositories\Interfaces\ITempUserDocumentRepository;
use App\Services\Interfaces\IBookingServices;
use Log;

class AuthServices implements IAuthService
{

	private $authUserRepository;
	private $otpService;
	private $deviceService;
	private $tempUserAddressRepository;
	private $tempUserRepository;
	private $bookingServices;
	public function __construct(
		IAuthUserRepository $authUserRepository,
		IUserDocumentRepository $userDocumentRepository,
		IOtpService $otpService,
		IDeviceService $deviceService,
		ITempUserDocumentRepository $tempUserDocumentRepository,
		ITempUserAddressRepository $tempUserAddressRepository,
		ITempUserRepository $tempUserRepository
	) {
		$this->otpService = $otpService;
		$this->authUserRepository = $authUserRepository;
		$this->userDocumentRepository = $userDocumentRepository;
		$this->deviceService = $deviceService;
		$this->tempUserDocumentRepository = $tempUserDocumentRepository;
		$this->tempUserAddressRepository = $tempUserAddressRepository;
		$this->tempUserRepository = $tempUserRepository;
	}
	public function register(CreateUserRequest $request)
	{
		$insert_data = AuthHelper::get_register_login_data($request);
		$this->validate_user_date($request);

		$otp_send_status = $this->otpService->send_otp($insert_data['country_code'], $insert_data['phone_number']);
		if (!$otp_send_status)
			throw new RecordNotFoundException(trans('Api/v1/auth.cannot_send_otp_please'));
		$user = $this->authUserRepository->create($insert_data);
		// save device details
		$this->deviceService->saveDeviceDetail($user->id);
		$user->access_token = $user->createToken('Api access token')->accessToken;
		return $user;
	}
	private function validate_user_date($insert_data)
	{
		// check email already registered or not
		$user = $this->authUserRepository->get_user(['email' => $insert_data['email']]);
		if ($user)
			throw new BadRequestException(trans('Api/v1/auth.email_already_registered'));
		$user = $this->authUserRepository->get_user(['phone_number' => $insert_data['phone_number']]);
		if ($user)
			throw new BadRequestException(trans('Api/v1/auth.phone_number_already_registered'));
		return true;
	}


	public function logoutUser(Request $request)
	{
		$user = Auth::user();
		$this->deviceService->deleteDevice($user->id);
		$accessToken = $user->token();
		$token = $request->user()->tokens->find($accessToken);
		if ($token->revoke()) {
			$this->deviceService->deleteDevice($user);
			return true;
		}
		return false;
	}


	public function sendOtp(SendOtpRequest $request)
	{
		// send otp on email
		if ($request->action == OtpEnum::sendEmail) {
			$send_email_otp =	$this->otpService->send_email_otp($request->email);
			if (!$send_email_otp)
				throw new BadRequestException(trans('Api/v1/auth. '));
			return true;
		} else {
			// send phone number otp
			$send_otp = $this->otpService->send_otp($request->country_code, $request->phone_number);
			if (!$send_otp)
				throw new BadRequestException(trans('Api/v1/auth.cannot_send_otp'));
			return true;
		}
	}

	public function verifyOtp(VerifyOtpRequest $request)
	{
		$otp = $this->otpService->verify_otp($request->otp_code, $request->phone_number, $request->country_code);
		if (!$otp)
			throw new BadRequestException(trans('Api/v1/auth.invalid_otp'));
		// check if otp expired or not
		if ($otp->expired_at < Carbon::now()) {
			throw new BadRequestException(trans('Api/v1/auth.otp_expired'));
		}
		if ($request->verify_type == OtpEnum::login_response) {
			$user = $this->authUserRepository->get_user(['country_code' => $request->country_code, 'phone_number' => $request->phone_number]);
			if (!$user)
				throw new RecordNotFoundException(trans('Api/v1/auth.user_not_found'));
			if ($user->is_blocked == UserEnum::blocked_user)
				throw new BlockedUserException(trans('Api/v1/auth.user_blocked'));
			// save the device details
			$this->deviceService->saveDeviceDetail($user->id);
			$user->access_token = $user->createToken('Api access token')->accessToken;
			return $user;
		}
		return true;
	}

	public function profile(Request $request)
	{
		$user = Auth::user();
		$user->access_token = $request->bearerToken();
		return $user;
	}
	public function uploadDocument(UploadUserDocumentRequest $request)
	{
		$user = Auth::user();
		$document_data = $request->documents;
		foreach ($document_data as $document) {
			$this->tempUserDocumentRepository->saveUserDocuments($user, $document);
		}
		$all_user_documents = $this->tempUserDocumentRepository->get_user_docs($user);
		$user->account_status = UserEnum::verification_progress;
		$user->save();
		if ($all_user_documents)
			return  UserDocumentsResource::collection($all_user_documents);
		return true;
	}

	public function changeEmail(ChangeEmailRequest $request)
	{
		$user = Auth::user();
		$otp = $this->otpService->verify_email_otp($request->email, $request->otp_code);
		if (!$otp)
			throw new BadRequestException(trans('Api/v1/auth.invalid_otp'));
		// check if otp expired or not
		if ($otp->expired_at < Carbon::now()) {
			throw new BadRequestException(trans('Api/v1/auth.otp_expired'));
		}
		$email_user = $this->authUserRepository->get_user(['email' => $request->email]);
		if ($email_user)
			throw new BadRequestException(trans('Api/v1/auth.email_already_registered'));
		$user->email = $request->email;
		$user->save();
		return true;
	}

	public function sendProfileChangeRequest(ChangeProfileRequest $request)
	{
		$user = Auth::user();
		if ($request->user_role and $request->user_role == UserEnum::user_customer) {
			$status = $this->authUserRepository->updateUser($user, AuthHelper::getUserUpdateData($request));
			if ($request->address) {
				foreach ($request->address as $address) {
					if (isset($address['address_id']))
						$this->authUserRepository->updateUserAddress($user, $address);
					else
						$this->authUserRepository->insertNewAddress($user, $address);
				}
			}
			return Auth::user();
		} else {

			$user_temp_info = $this->tempUserRepository->getUserTempInfo($user->id);
			if ($user_temp_info)
				throw new BadRequestException(trans('Api/v1/auth.profile_under_review'));
			$status = $this->tempUserRepository->saveUserTempInfo(AuthHelper::getUserTempData($request, $user->id));
			if (!$status)
				throw new BadRequestException(trans('Api/v1/auth.something_went_wrong'));

			//save user address data
			if ($request->address) {
				$temp_user_address = $this->tempUserAddressRepository->getUserAddress($user->id);
				if ($temp_user_address)
					throw new BadRequestException(trans('Api/v1/auth.profile_under_review'));
				$save_address_status =	$this->tempUserAddressRepository->saveUserAddress(AuthHelper::getInsertUserAddressData($request->address, $user->id));
				if (!$save_address_status)
					throw new BadRequestException(trans('Api/v1/auth.something_went_wrong'));
			}
			$user->account_status = UserEnum::verification_progress;
			$user->save();
			return true;
		}
	}


	// update user profile
	public function changeProfileImage(ChangeProfileImageRequest $request)
	{
		$user = Auth::user();
		$user->profile_picture = $request->profile_image;
		$user->save();
		return true;
	}

	public function changePhoneNumber(ChangePhoneNumberRequest $request)
	{
		$user = Auth::user();
		$otp = $this->otpService->verify_otp($request->otp_code, $request->phone_number, $request->country_code);
		if (!$otp)
			throw new BadRequestException(trans('Api/v1/auth.invalid_otp'));
		// check if otp expired or not
		if ($otp->expired_at < Carbon::now()) {
			throw new BadRequestException(trans('Api/v1/auth.otp_expired'));
		}
		$getUserWithIncomingNumber = $this->authUserRepository->get_user(['phone_number' => $request->phone_number, 'country_code' => $request->country_code]);
		if ($getUserWithIncomingNumber)
			throw new BadRequestException(trans('Api/v1/auth.phone_number_already_used'));
		$user->phone_number = $request->phone_number;
		$user->country_code = $request->country_code;
		$user->save();
		return true;
	}
	public function login(LoginRequest $request)
	{
		$user = $this->authUserRepository->get_user(['phone_number' => $request->phone_number, 'country_code' => $request->country_code]);
		if (!$user)
			throw new BadRequestException(trans('Api/v1/auth.user_not_found_with_this_number'));
		// send phone number otp
		if ($user->role != UserEnum::user_vendor) {
			throw new RecordNotFoundException(trans('Api/v1/auth.user_not_found'));
		}
		if ($user->is_blocked == UserEnum::blocked_user)
			throw new BadRequestException(trans('Api/v1/auth.user_blocked'));
		$send_otp = $this->otpService->send_otp($request->country_code, $request->phone_number);
		if (!$send_otp)
			throw new BadRequestException(trans('Api/v1/auth.cannot_send_otp'));
		// save the device details
		$this->deviceService->saveDeviceDetail($user->id);
		$user->access_token = $user->createToken('Api access token')->accessToken;
		return 	$user;
	}

	// check user exist or not
	public function checkUser(CheckUserRequest $request)
	{
		$response = ['exist' => 0];
		if ($request->email) {
			$user = $this->authUserRepository->get_user(['email' => $request->email]);
			if ($user)
				$response['exist'] = 1;
		} else {
			$user = $this->authUserRepository->get_user(['phone_number' => $request->phone_number, 'country_code' => $request->country_code]);
			if ($user)
				$response['exist'] = 1;
		}
		return $response;
	}

	public function changeStatus()
	{
		$user = Auth::user();
		$offline = UserEnum::offline;
		if ($user->is_offline == UserEnum::online) {
			$user->is_offline = UserEnum::offline;
			$user->save();
			return ['offline' => $offline];
		} else {
			$user->is_offline = UserEnum::online;
			$user->save();
			$offline = UserEnum::online;
			return ['offline' => $offline];
		}
	}
	// delete address
	public function deleteAddress(DeleteAddressRequest $request)
	{
		$user = Auth::user();
		$user_address = $user->user_verified_address()->whereId($request->address_id)->first();
		if (!$user_address)
			throw new RecordNotFoundException(trans('Api/v1/auth.address_not_found'));
		$user_address->delete();
		return trans('Api/v1/auth.address_deleted_successfully');
	}
	public function updateLocation(UpdateVendorLocationRequest $request)
	{
		$auth_vendor = Auth::user();
		$find_active_vendor_service = $auth_vendor->vendor_bookings()->outForService()->get();
		if (!$find_active_vendor_service->count() > 0) {
			throw new RecordNotFoundException(trans('Api/v1/auth.out_for_service_booking_not_found'));
		}
		// change vendor location
		$location = $auth_vendor->vendor_locations()->first();
		if ($location) {
			$location->latitude = $request->latitude;
			$location->longitude = $request->longitude;
			$location->save();
		} else {
			$auth_vendor->vendor_locations()->create($request->only('latitude', 'longitude'));
		}
		if ($find_active_vendor_service->count() > 0) {
			$booking_users_id = $find_active_vendor_service->pluck('user_id')->unique();
			foreach ($booking_users_id as $user_id) {
				PushNotificationHelper::send($auth_vendor->id, $user_id, trans('Api/v1/auth.vendor_location_changed'),  trans('Api/v1/auth.vendor_location_changed_description'), NotificationEnum::VENDOR_LOCATION_CHANGED, false);
			}
		}
		return trans('Api/v1/auth.location_changed');
	}
}

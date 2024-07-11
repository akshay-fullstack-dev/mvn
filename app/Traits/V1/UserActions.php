<?php

namespace App\Traits\V1;

use App\Http\Requests\V1\Auth\ChangeEmailRequest;
use App\Http\Requests\V1\Auth\ChangePhoneNumberRequest;
use App\Http\Requests\V1\Auth\ChangeProfileImageRequest;
use App\Http\Requests\V1\Auth\ChangeProfileRequest;
use App\Http\Requests\V1\Auth\ChangeStatusRequest;
use App\Http\Requests\V1\Auth\CheckUserRequest;
use App\Http\Requests\V1\Auth\CreateUserRequest;
use App\Http\Requests\V1\Auth\DeleteAddressRequest;
use App\Http\Requests\V1\Auth\LoginRequest;
use App\Http\Requests\V1\Auth\SendOtpRequest;
use App\Http\Requests\V1\Auth\UpdateUserProfile;
use App\Http\Requests\V1\Auth\UpdateVendorLocationRequest;
use App\Http\Requests\V1\Auth\UploadUserDocumentRequest;
use App\Http\Requests\V1\Auth\VerifyOtpRequest;
use App\Services\Interfaces\IAuthService;
use Illuminate\Http\Request;

trait UserActions
{
	private $authService;

	public function __construct(IAuthService  $authService)
	{
		$this->authService = $authService;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function register(CreateUserRequest $request)
	{
		return  $this->authService->register($request);
	}

	public function logoutUser(Request $request)
	{
		return $this->authService->logoutUser($request);
	}
	public function sendOtp(SendOtpRequest $request)
	{
		return $this->authService->sendOtp($request);
	}

	public function verifyOtp(VerifyOtpRequest $request)
	{
		return $this->authService->verifyOtp($request);
	}

	public function profile(Request $request)
	{
		return $this->authService->profile($request);
	}

	// upload user documents
	public function uploadDocument(UploadUserDocumentRequest $request)
	{
		return $this->authService->uploadDocument($request);
	}

	public function changeEmail(ChangeEmailRequest $request)
	{
		return $this->authService->changeEmail($request);
	}
	// change the variable name
	public function sendProfileChangeRequest(ChangeProfileRequest $request)
	{
		return $this->authService->sendProfileChangeRequest($request);
	}
	public function changePhoneNumber(ChangePhoneNumberRequest $request)
	{
		return $this->authService->changePhoneNumber($request);
	}
	public function changeProfileImage(ChangeProfileImageRequest $request)
	{
		return $this->authService->changeProfileImage($request);
	}
	public function login(LoginRequest $request)
	{
		return $this->authService->login($request);
	}
	public function checkUser(CheckUserRequest $request)
	{
		return $this->authService->checkUser($request);
	}
	public function changeStatus()
	{
		return $this->authService->changeStatus();
	}
	public function deleteAddress(DeleteAddressRequest $request)
	{
		return $this->authService->deleteAddress($request);
	}

	public function updateLocation(UpdateVendorLocationRequest $request)
	{
		return $this->authService->updateLocation($request);
	}
}

<?php

namespace App\Traits\V1\Client;

use App\Services\Interfaces\Client\IClientAuthService;
use App\Http\Requests\V1\ClientRequests\Auth;

trait UserClientActions
{
	private $authService;

	public function __construct(IClientAuthService  $authService)
	{
		$this->authService = $authService;
	}
	public function socialLogin(Auth\SocialLoginRequest $request)
	{
		return $this->authService->socialLogin($request);
	}
	public function register(Auth\CreateUserRequest $request)
	{
		return $this->authService->register($request);
	}
	public function changePassword(Auth\ChangePasswordRequest $request)
	{
		return $this->authService->changePassword($request);
	}
	public function login(Auth\LoginRequest $request)
	{
		return $this->authService->login($request);
	}
	public function forgotPassword(Auth\ForgotPasswordRequest $request)
	{
		return $this->authService->forgotPassword($request);
	}
}

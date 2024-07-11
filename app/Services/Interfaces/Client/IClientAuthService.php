<?php

namespace App\Services\Interfaces\Client;

use App\Http\Requests\V1\ClientRequests\Auth\CreateUserRequest;
use App\Http\Requests\V1\ClientRequests\Auth\SocialLoginRequest;
use Illuminate\Http\Request;

interface IClientAuthService
{
	public function register(CreateUserRequest $request);
	public function socialLogin(SocialLoginRequest $request);

}

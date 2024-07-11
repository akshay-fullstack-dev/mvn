<?php

namespace App\Services\Interfaces;

use App\Http\Requests\V1\Auth\CreateUserRequest;
use App\Http\Requests\V1\Auth\UpdateUserProfile;
use App\Http\Requests\V1\Auth\UploadUserDocumentRequest;
use Illuminate\Http\Request;

interface IAuthService
{
	public function register(CreateUserRequest $request);
	public function logoutUser(Request $request);


	// upload user documents
	public function uploadDocument(UploadUserDocumentRequest $request);
}

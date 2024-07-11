<?php

namespace App\Services\Interfaces;

use App\Http\Requests\V1\Media\DeleteImageRequest;
use App\Http\Requests\V1\Media\ImageUploadRequest;


interface IMediaServices
{
	public function uploadImage(ImageUploadRequest $request);
	public function deleteImage(DeleteImageRequest $request);
}

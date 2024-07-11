<?php

namespace App\Traits\V1;

use App\Http\Requests\V1\Media\DeleteImageRequest;
use App\Http\Requests\V1\Media\ImageUploadRequest;
use App\Services\Interfaces\IMediaServices;

trait MediaActions
{
	private $mediaAction;

	public function __construct(IMediaServices  $mediaAction)
	{
		$this->mediaAction = $mediaAction;
	}
	public function uploadImage(ImageUploadRequest $request)
	{
		return	$this->mediaAction->uploadImage($request);
	}

	public function deleteImage(DeleteImageRequest $request)
	{
		return	$this->mediaAction->deleteImage($request);
	}
}

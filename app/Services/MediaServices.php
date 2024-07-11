<?php

namespace App\Services;

use App\Exceptions\RecordNotFoundException;
use App\Http\Requests\V1\Media\DeleteImageRequest;
use App\Http\Requests\V1\Media\ImageUploadRequest;
use App\Services\Interfaces\IMediaServices;
use Illuminate\Support\Facades\Storage;


class MediaServices implements IMediaServices
{
	public function uploadImage(ImageUploadRequest $request)
	{
		if ($request->hasfile('image')) {
			$file = $request->file('image');
			$filename = time() . $file->getClientOriginalName();
			//store url
			$storagePath = Storage::disk('s3')->put($filename, file_get_contents($file));
			$url = Storage::disk('s3')->url($filename);
			//return url
			$success['url'] = $url;
			return $success;
		}
	}

	public function deleteImage(DeleteImageRequest $request)
	{
		//get file url
		$file = $request->url;
		$filename = $file;
		$filename = basename($file);
		if (!Storage::disk('s3')->exists($filename)) {
			throw new RecordNotFoundException(trans('api/v1/media.image_not_found'));
		}
		Storage::disk('s3')->delete($filename);
		return true;
	}
}

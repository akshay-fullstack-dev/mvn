<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Storage;
class MediaHelper
{
    public static function getStorageUrl($image_name) 
    {
        $s3 = Storage::disk('s3')->getAdapter()->getClient();
        return $s3->getObjectUrl( env('AWS_BUCKET'),$image_name);
    }
}

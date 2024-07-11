<?php

namespace App\Http\Resources\v1\Media;

use App\Helpers\V1\MediaHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class Images extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'service_images' => $this->name ? MediaHelper::getStorageUrl($this->name) : ""
        ];
    }
}

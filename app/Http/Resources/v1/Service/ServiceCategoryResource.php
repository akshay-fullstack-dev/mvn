<?php

namespace App\Http\Resources\v1\Service;

use App\Helpers\V1\MediaHelper;
use App\Http\Resources\v1\Media\Images;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceCategoryResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $service_category_image = "";
        if ($this->media->first()) {
            $service_category_image = MediaHelper::getStorageUrl($this->media->first()->file_name);
        }
        return [
            'category_id' => $this->id,
            'category_name' => $this->name,
            'category_description' => $this->description,
            'category_image' => $service_category_image
        ];
    }
}

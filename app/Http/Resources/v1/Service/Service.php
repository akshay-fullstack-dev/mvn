<?php

namespace App\Http\Resources\v1\Service;

use App\Helpers\V1\MediaHelper;
use App\Http\Resources\v1\Media\Images;
use Illuminate\Http\Resources\Json\JsonResource;

class Service extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $is_enrolled = ($this->relationLoaded('user_services')) ? 1 : 0;

        // process service images
        $service_images = [];
        if (isset($this->media) and count($this->media) > 0) {
            foreach ($this->media as $media) {
                if ($media->file_name != "")
                    $service_images[] = MediaHelper::getStorageUrl($media->file_name);
            }
        }
        $whats_included = [];
        //  process whats inclued
        if (isset($this->service_inclusions) and $this->service_inclusions) {
            foreach ($this->service_inclusions as $inclusion) {
                $whats_included[] = $inclusion['name'];
            }
        }
        return [
            'service_id' => $this->id,
            'service_name' => $this->name ?? null,
            'service_description' => $this->description ?? null,
            'whats_included' => $whats_included,
            'spare_parts' => $this->spare_parts,
            'admin_service_price' => (float)$this->price ?? null,
            'admin_service_time' => date('H:i', strtotime($this->approx_time)) ?? null,
            'enrolled' => $is_enrolled,
            'vendor_service_price' => ($is_enrolled == 1 and isset($this->user_services[0]['price'])) ? $this->user_services[0]['price'] : null,
            'spare_part_price' => $this->spare_part_price ?? 0,
            'dealer_price' => doubleval($this->dealer_price),
            'vendor_service_time' => ($is_enrolled == 1 and isset($this->user_services[0]['time'])) ? date('H:i', strtotime($this->user_services[0]['time'])) : null,

            // we have to show the images array of the service remove when images uploaded
            'service_images' =>  $service_images,
            'certified_vendor_id' => isset($this->shop_certified_vendor_id) ? $this->shop_certified_vendor_id : null
        ];
    }
}

<?php

namespace App\Http\Resources\v1\Package;

use App\Helpers\V1\MediaHelper;
use App\Http\Resources\v1\Service\Service;
use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $services = [];
        foreach ($this->package_services as $package_service) {
            $services[] = [
                'service_id' => $package_service->service->id,
                'service_name' => $package_service->service->name,
            ];
        }
        $package_media = [];
        if (isset($this->media) and count($this->media) > 0) {
            foreach ($this->media as $media) {
                if ($media->file_name != "")
                    $package_media[] = MediaHelper::getStorageUrl($media->file_name);
            }
        }

        return [
            'package_id' => $this->id,
            'package_name' => $this->name ?? null,
            'package_description' => $this->description ?? null,
            'media' => $package_media,
            'no_of_times' => $this->no_of_times,
            'normal_price' => $this->normal_price,
            'dealer_price' => $this->dealer_price,
            'booking_gap' => $this->booking_gap,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'package_services' => $services
        ];
    }
}

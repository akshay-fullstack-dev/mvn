<?php

namespace App\Http\Resources\v1\Package;


use App\Http\Resources\v1\Booking\BookingResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Helpers\V1\MediaHelper;

class UserPackageHistoryResource extends JsonResource
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
        foreach ($this->package->package_services as $package_service) {
            $services[] = [
                'service_id' => $package_service->service->id,
                'service_name' => $package_service->service->name,
            ];
        }
        $package_media = [];
        if (isset($this->package->media) and count($this->package->media) > 0) {
            foreach ($this->package->media as $media) {
                if ($media->file_name != "")
                    $package_media[] = MediaHelper::getStorageUrl($media->file_name);
            }
        }

        return [
            'order_id' => $this->id,
            // --------package data start---------------
            'package_id' => $this->package->id,
            'package_name' => $this->package->name ?? null,
            'package_description' => $this->package->description ?? null,
            'media' => $package_media,
            'no_of_times' => $this->package->no_of_times,
            'normal_price' => $this->package->normal_price,
            'dealer_price' => $this->package->dealer_price,
            'booking_gap' => $this->package->booking_gap,
            'start_date' => $this->package->start_date,
            'end_date' => $this->package->end_date,
            'package_services' => $services,
            // -----------------end of package data-------------

            'booking' => BookingResource::collection($this->booking_by_order_id)
        ];
    }
}

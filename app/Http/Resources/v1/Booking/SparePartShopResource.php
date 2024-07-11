<?php

namespace App\Http\Resources\v1\Booking;

use Illuminate\Http\Resources\Json\JsonResource;

class SparePartShopResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'address_id' => $this->id,
            'name' => $this->shop_name,
            'city' => $this->city ?? "",
            'country' => $this->country ?? "",
            'zip_code' => $this->postal_code ?? "",
            'formatted_address' => $this->formatted_address ?? "",
            'additional_info' => $this->additional_shop_information ?? "",
            'latitude' => $this->lat ?? "",
            'longitude' => $this->long ?? "",
        ];
    }
}

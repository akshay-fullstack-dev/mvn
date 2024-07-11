<?php

namespace App\Http\Resources\v1\Auth;

use Illuminate\Http\Resources\Json\JsonResource;

class UserAddressResource extends JsonResource
{
    public function __construct($resource)
    {
        parent::__construct($resource);
    }
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
            'type' => $this->type,
            'city' => $this->city ?? "",
            'house_no' => $this->house_no ?? "",
            'state' => $this->state ?? "",
            'country' => $this->country ?? "",
            'zip_code' => $this->zip_code ?? "",
            'formatted_address' => $this->formatted_address ?? "",
            'additional_info' => $this->additional_info ?? "",
            'latitude' => $this->latitude ?? "",
            'longitude' => $this->longitude ?? "",
        ];
    }
}

<?php

namespace App\Http\Resources\v1\Booking;

use App\Http\Resources\v1\Service\Service;
use Illuminate\Http\Resources\Json\JsonResource;
use stdClass;

class BookingBillImagesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $response = [];
        foreach ($this['bills'] as $bill) {
            array_push($response, $bill->bill_image);
        }
        return $response;
    }
}

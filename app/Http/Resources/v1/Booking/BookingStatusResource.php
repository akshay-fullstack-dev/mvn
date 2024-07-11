<?php

namespace App\Http\Resources\v1\Booking;

use App\Http\Resources\v1\Service\Service;
use Illuminate\Http\Resources\Json\JsonResource;
use stdClass;

class BookingStatusResource extends JsonResource
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
            'id' => $this->id,
            'booking_status' => $this->booking_status,
            'changed_at' => date('Y-m-d H:i:s', strtotime($this->created_at))
        ];
    }
}

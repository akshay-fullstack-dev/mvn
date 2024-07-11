<?php

namespace App\Http\Resources\v1\Booking;

use App\Http\Resources\v1\Service\Service;
use Illuminate\Http\Resources\Json\JsonResource;
use stdClass;

class PaymentCouponResource extends JsonResource
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
            'coupon_id' => $this->coupon_id,
            'discount_amount' => $this->discount_amount
        ];
    }
}

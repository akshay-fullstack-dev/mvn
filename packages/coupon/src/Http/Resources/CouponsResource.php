<?php

namespace IntersoftCoupon\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CouponsResource extends JsonResource
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
            'coupon_id' => $this->id,
            'coupon_name' => $this->coupon_name,
            'coupon_code' => $this->coupon_code,
            'coupons_type' => $this->coupon_type,
            'coupons_discount' => $this->coupon_discount,
            'coupons_description' => $this->coupon_description ?? "",
            'coupons_min_amount' => $this->coupon_min_amount ?? null,
            'coupon_max_amount' => $this->coupon_max_amount ?? null,
            'coupon_start_date' => $this->start_date ?? "",
            'coupon_end_date' => $this->end_date ?? "",
        ];
    }
}

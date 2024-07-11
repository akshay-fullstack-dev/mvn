<?php

namespace App\Http\Resources\v1\Booking;

use App\Http\Resources\v1\Service\Service;
use Illuminate\Http\Resources\Json\JsonResource;
use stdClass;

class BookingPaymentResource extends JsonResource
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
            'payment_id' => $this->id,
            'total_amount' => $this->total_amount,
            'total_amount_paid' => $this->total_amount_paid,
            'total_delivery_charges' => $this->delivery_charges,
            'delivery_charges_received_by_vendor' => $this->delivery_charge_received_by_vendor,
            'admin_delivery_charge' => $this->delivery_charge_received_by_admin,
            'amount_received_by_vendor' => $this->basic_service_charge_received_by_vendor + $this->delivery_charge_received_by_vendor,
            'basic_service_charge' => (float)number_format($this->basic_service_charge, 2),
            'via_wallet' => $this->via_wallet,
            'basic_service_charge_received_by_vendor' => $this->basic_service_charge_received_by_vendor,
            'coupon_details' => $this->coupon_id ? new PaymentCouponResource($this) : null,
        ];
    }
}

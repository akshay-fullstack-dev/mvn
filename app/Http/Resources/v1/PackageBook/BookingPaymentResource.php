<?php

namespace App\Http\Resources\v1\PackageBook;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingPaymentResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return ([

            "id" => $this->id,
            "coupon_id" => $this->coupon_id,
            "amount_paid" => $this->amount_paid,
            "total_amount" => $this->total_amount,
            "total_amount_paid" => $this->total_amount_paid,
            "currency_code" => $this->currency_code,
            "via_wallet" => $this->via_wallet,
            "is_package_maintance" => $this->is_package_maintance,
            "basic_service_charge_received_by_admin" => $this->basic_service_charge_received_by_admin,
            "basic_service_charge_received_by_vendor" => $this->basic_service_charge_received_by_vendor,
            "discount_amount" => $this->discount_amount,
            "is_refunded" => $this->is_refunded,
            "payment_settled" => $this->payment_settled,
            "is_pending_payment" => $this->is_pending_payment,
            "refund_amount" => $this->refund_amount,
            "is_cancel" => $this->is_cancel,
        ]);
    }
}

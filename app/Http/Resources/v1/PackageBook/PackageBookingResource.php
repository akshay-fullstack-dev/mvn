<?php

namespace App\Http\Resources\v1\PackageBook;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageBookingResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
           
        return [
                "id" => $this->id,
                "order_id" => $this->order_id,
                "user_id" => $this->user_id,
                "vendor_id" => $this->vendor_id,
                "service_id" =>$this->service_id,
                "address_id" =>$this->address_id,
                "payment_id" =>$this->payment_id,
                "package_id" => $this->package_maintaince_id,
                "vehicle_id" => $this->vehicle_id,
                "booking_start_time" => $this->booking_start_time,
                "booking_end_time" => $this->booking_end_time,
                "booking_status" => $this->booking_status,
                "cancel_reason" => $this->cancel_reason,
                "booking_type" => $this->booking_type,
                "addition_info" => $this->addition_info,
                "created_at" => $this->created_at,
                "updated_at" => $this->updated_at,
                "deleted_at" => $this->deleted_at,
                "booking_vehicle"=>new BookingVehicle($this->booking_vehicle),
                 "booking_payment"=>new BookingPaymentResource($this->booking_payment)
            ];
    
    }
}


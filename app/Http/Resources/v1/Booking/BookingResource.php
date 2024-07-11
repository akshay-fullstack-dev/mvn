<?php

namespace App\Http\Resources\v1\Booking;

use App\Http\Resources\v1\Auth\UserResource;
use App\Http\Resources\v1\Service\Service;
use App\Http\Resources\v1\Vehicle\VehicleResource;
use Illuminate\Http\Resources\Json\JsonResource;
use stdClass;

class BookingResource extends JsonResource
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
            'booking_details' => [
                'vehicle_id' => $this->vehicle_id,
                'booking_start_time' => $this->booking_start_time,
                'booking_end_time' => $this->booking_end_time,
                'addition_info' => $this->addition_info,
                'vehicle_details' => $this->booking_vehicle ? new VehicleResource($this->booking_vehicle) : new stdClass,
            ],
            'booking_id' => $this->id,
            'order_id' => $this->order_id,
            'booking_type' => $this->booking_type,
            'vendor_id' => $this->vendor_id,
            'package_id' => $this->package_id,
            'address_id' => $this->address_id,
            'booking_status' => $this->booking_status,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'booking_start_time'=>$this->booking_start_time,
            'booking_end_time'=>$this->booking_end_time,
            'package_details' => new stdClass,
            'service_details' => new Service($this->service),
            'payment_details' => new BookingPaymentResource($this->booking_payment),
            'vendor_details' => $this->booking_vendor ? new UserResource($this->booking_vendor) : new stdClass,
            'booking_status_history' => BookingStatusResource::collection($this->booking_status_history),
            'customer_details' => new UserResource($this->customer_details),
            'booking_bills' => $this->booking_bills()->count() > 0 ? new BookingBillImagesResource(['bills' => $this->booking_bills]) : [],
            'near_by_shops' => ($this->near_shop_locations && $this->near_shop_locations->count() > 0) ? SparePartShopResource::collection($this->near_shop_locations) : []

        ];
    }
}

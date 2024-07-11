<?php

namespace App\Http\Resources\v1\PackageBook;

use App\Helpers\V1\MediaHelper;
use App\Http\Resources\v1\Service\Service;
use Illuminate\Http\Resources\Json\JsonResource;


class PackageBookListResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // dd($this);
        return [
            "user_id"=>$this->user_id,
            'package_id'=>$this->package_id,
            'order_id'=>$this->order_id,
            'is_cancel'=>$this->is_cancel,
             "package"=> new PackageResource($this->packages),
               "booking"=>PackageBookingResource::collection($this->bookings),
           
        ];
    }
}

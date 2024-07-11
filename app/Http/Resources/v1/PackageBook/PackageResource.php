<?php

namespace App\Http\Resources\v1\PackageBook;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
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
            "name" => $this->name,
            "description" => $this->description,
            "status" => $this->status,
            "no_of_times" => $this->no_of_times,
            "normal_price" => $this->normal_price,
            "dealer_price" => $this->dealer_price,
            "sparepartdescription" => $this->sparepartdescription,
            "booking_gap" => $this->booking_gap,
            "start_date" => $this->start_date,
            "end_date" => $this->end_date,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "services"=>PackageServiceResource::collection($this->package_services)

        ];
    }
}

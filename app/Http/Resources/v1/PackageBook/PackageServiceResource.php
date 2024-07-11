<?php

namespace App\Http\Resources\v1\PackageBook;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageServiceResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
    //   dd($this);
        return [
            "name" => $this->service->name,
            "service_category_id" => $this->service->service_category_id,
            "description" =>$this->service->description,
            "price" => $this->service->price,
            "spare_part_price" => $this->service->spare_part_price,
            "dealer_price" => $this->service->dealer_price,
            "spare_parts" => $this->service->spare_parts,
            "created_at" =>$this->service->created_at,
            "updated_at" => $this->service->updated_at,
            "approx_time" => $this->service->approx_time,
            "deleted_at" => $this->service->deleted_at
        ];
    }
    }


<?php

namespace App\Http\Resources\v1\PackageBook;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingVehicle extends JsonResource
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
        return ([
            "id" => $this->id,
            "vehicle_company_id" => $this->vehicle_company_id,
            "cylinders" => $this->cylinders,
            "displ" => $this->displ,
            "drive" => $this->drive,
            "engId" => $this->engId,
            "eng_dscr" => $this->eng_dscr,
            "fuelType" => $this->fuelType,
            "fuelType1" => $this->fuelType1,
            "model" => $this->model,
            "trany" => $this->trany,
            "VClass" => $this->VClass,
            "year" => $this->year,
            "trans_dscr" => $this->trans_dscr,
        ]);
    }
}

<?php

namespace App\Http\Resources\v1\Vehicle;

use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
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
            'id' => $this->id,
            'company' => $this->vehicle_company->make,
            'model' => $this->model,
            'year' => $this->year,
            'engine' => (double)$this->displ * 1000,
            'cylinders' => $this->cylinders,
            'vin_number' =>$this->vin_number
        ];
    }
}

<?php

namespace App\Http\Resources\v1\Vehicle;

use Illuminate\Http\Resources\Json\JsonResource;

class UserVehicleResource extends JsonResource
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
            'user_vehicle_id' => $this->id,
            'vehicle_id' => $this->vehicle_id,
            'purchased_year' => $this->purchased_year,
            'insurance_company_name' => $this->insurance_company_name,
            'insurance_policy_number' => $this->insurance_policy_number,
            'vin_number' => $this->vin_number,
            'company' => $this->vehicle->vehicle_company->make,
            'company_id' => $this->vehicle->vehicle_company->id,
            'model' => $this->vehicle->model,
            'year' =>  (string)$this->purchased_year,
            'engine' => (float)$this->vehicle->displ * 1000
        ];
    }
}

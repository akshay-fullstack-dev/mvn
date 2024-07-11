<?php

namespace App\Models;

use App\Http\Resources\v1\Vehicle\VehicleResource;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    public function setResource($vehicle)
    {
        return new VehicleResource($vehicle);
    }
    public function vehicle_company()
    {
        return $this->belongsTo(VehiclesCompany::class, 'vehicle_company_id');
    }
}

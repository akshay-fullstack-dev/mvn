<?php

namespace App\Models;

use App\Http\Resources\v1\Vehicle\UserVehicleResource;
use App\Http\Resources\v1\Vehicle\VehicleCollection;
use Illuminate\Database\Eloquent\Model;

class UserVehicles extends Model
{
    protected $guarded = [];
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function setResources($service_data)
    {
        return new VehicleCollection($service_data);
    }
    public function setResource($data)
    {
        return new UserVehicleResource($data);
    }
}

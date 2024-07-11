<?php

namespace App\Services\Interfaces;

use App\Http\Requests\V1\Vehicle\DeleteVehicleRequest;
use App\Http\Requests\V1\Vehicle\GetVehicleModelRequest;
use Illuminate\Http\Request;

interface IVehicleServices
{
	public function getVehicleCompany(Request $request);
	public function getModelDetails(GetVehicleModelRequest $request);
	public function deleteVehicle(DeleteVehicleRequest $request);
}

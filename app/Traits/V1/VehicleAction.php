<?php

namespace App\Traits\V1;

use App\Http\Requests\V1\Vehicle\AddVehicleRequest;
use App\Http\Requests\V1\Vehicle\DeleteVehicleRequest;
use App\Http\Requests\V1\Vehicle\GetVehicleModelRequest;
use App\Http\Requests\V1\Vehicle\UpdateVehicleRequest;
use App\Services\Interfaces\IVehicleServices;
use Illuminate\Http\Request;

trait VehicleAction
{
	private $vehicleService;

	public function __construct(IVehicleServices  $vehicleService)
	{
		$this->vehicleService = $vehicleService;
	}

	public function getVehicleCompany(Request $request)
	{
		return $this->vehicleService->getVehicleCompany($request);
	}
	public function getCompanyModel(GetVehicleModelRequest $request)
	{
		return $this->vehicleService->getModelDetails($request);
	}
	public function addVehicle(AddVehicleRequest $request)
	{
		return $this->vehicleService->addVehicle($request);
	}
	public function deleteVehicle(DeleteVehicleRequest $request)
	{
		return $this->vehicleService->deleteVehicle($request);
	}
	public function getUserVehicle(Request $request)
	{
		return $this->vehicleService->getUserVehicles($request);
	}
	public function updateUserVehicle(UpdateVehicleRequest $request)
	{
		return $this->vehicleService->updateUserVehicle($request);
	}
}

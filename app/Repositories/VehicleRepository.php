<?php

namespace App\Repositories;

use App\Enum\DocumentEnum;
use App\Models\Vehicle;
use App\Repositories\GenericRepository;
use App\Repositories\Interfaces\IVehicleRepository;

class VehicleRepository extends GenericRepository implements IVehicleRepository
{
	public function model()
	{
		return Vehicle::class;
	}

	public function getCompany()
	{
		$company_data = \DB::table('vehicles_compnies')->get();
		if ($company_data->count() > 0)
			return $company_data;
		return false;
	}
	public function getCompanyModelDetails($company_id, $item_per_page)
	{
		$company_models = $this->model->where('vehicle_company_id', $company_id)->paginate($item_per_page);
		return $company_models;
	}
}

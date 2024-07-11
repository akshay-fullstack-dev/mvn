<?php

namespace App\Repositories\Interfaces;

interface IVehicleRepository extends IGenericRepository
{
	public function getCompany();
	public function getCompanyModelDetails($id,$item_per_page);
}

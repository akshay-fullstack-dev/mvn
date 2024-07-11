<?php

namespace App\Repositories;

use App\Models\UserVehicles;
use App\Repositories\GenericRepository;
use App\Repositories\Interfaces\IUserVehicleRepository;

class UserVehicleRepository extends GenericRepository implements IUserVehicleRepository
{
	public function model()
	{
		return UserVehicles::class;
	}
	public function getDetails($where = null)
	{
		
		return $this->model->where($where)->first();
	}
}

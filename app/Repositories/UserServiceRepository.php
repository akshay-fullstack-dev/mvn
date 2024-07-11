<?php

namespace App\Repositories;

use App\Models\UserService;
use App\Repositories\GenericRepository;
use App\Repositories\Interfaces\IUserServiceRepository;

class UserServiceRepository extends GenericRepository implements IUserServiceRepository
{
	public function model()
	{
		return UserService::class;
	}

	public function getUserService(array $where)
	{
		return $this->model->where($where)->first();
	}
	public function get_vendor_service($service_ids)
	{
		return $this->model->whereIn('service_id', $service_ids)->get();
	}
	
}

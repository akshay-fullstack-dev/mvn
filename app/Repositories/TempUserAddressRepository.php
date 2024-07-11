<?php

namespace App\Repositories;

use App\Models\UserTempAddress;
use App\Repositories\GenericRepository;
use App\Repositories\Interfaces\ITempUserAddressRepository;

class TempUserAddressRepository extends GenericRepository implements ITempUserAddressRepository
{
	public function model()
	{
		return UserTempAddress::class;
	}
	public function getUserAddress($user_id)
	{
		$user_address = $this->model->where('user_id', $user_id)->get();
		if ($user_address->count() > 0)
			return true;
		return false;
	}

	public function saveUserAddress($insertData)
	{
		return $this->model->insert($insertData);
	}
}

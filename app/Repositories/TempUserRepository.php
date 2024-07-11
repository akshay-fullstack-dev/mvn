<?php

namespace App\Repositories;

use App\Models\UserTempInfo;
use App\Repositories\GenericRepository;
use App\Repositories\Interfaces\ITempUserRepository;

class TempUserRepository extends GenericRepository implements ITempUserRepository
{
	public function model()
	{
		return UserTempInfo::class;
	}
	public function getUserTempInfo($user_id)
	{
		$temp_info = $this->model->where('user_id', $user_id)->get();
		if ($temp_info->count() > 0)
			return true;
		return false;
	}
	public function saveUserTempInfo($insetData)
	{
		return $this->model->create($insetData);
	}
}

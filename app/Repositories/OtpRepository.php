<?php

namespace App\Repositories;
use App\Repositories\GenericRepository;
use App\Repositories\Interfaces\IOtpRepository;
use App\Models\UserOtp;

class OtpRepository extends GenericRepository implements IOtpRepository
{
	public function model()
	{
		return UserOtp::class;
	}
	public function get_old($where)
	{
		return $this->model->where($where)->first();
	}
}

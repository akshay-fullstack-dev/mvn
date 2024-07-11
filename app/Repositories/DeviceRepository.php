<?php

namespace App\Repositories;

use App\Repositories\GenericRepository;
use App\Repositories\Interfaces\IDeviceRepository;
use App\Models\DeviceDetail;

class DeviceRepository extends GenericRepository implements IDeviceRepository
{
	public function model()
	{
		return DeviceDetail::class;
	}

	public function get_device($where)
	{
		return $this->model->where($where)->first();
	}
	public function delete_device_details($where)
	{
		return $this->model->where($where)->delete();
	}
}

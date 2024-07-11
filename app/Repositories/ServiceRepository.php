<?php

namespace App\Repositories;

use App\Models\Service;
use App\Repositories\GenericRepository;
use App\Repositories\Interfaces\IServiceRepository;

class ServiceRepository extends GenericRepository implements IServiceRepository
{
	public function model()
	{
		return Service::class;
	}
	public function getServiceWithoutEnrolled($user_id, $item_per_page, array $where = [])
	{
		$services = $this->model->whereDoesntHave('user_services', function ($query) use ($user_id) {
			$query->where('user_id', $user_id);
		});
		if (count($where) > 0)
			$services->where($where);
		$services->with(['media', 'service_inclusions']);
		$result = $services->paginate($item_per_page);
		if ($result->count() > 0)
			return $result;
		return false;
	}
	public function getEnrolledServices($user_id, $item_per_page, array $where = [])
	{
		$services = $this->model->whereHas('user_services', function ($q) use ($user_id) {
			$q->where('user_id', $user_id);
		})->with(['user_services' => function ($q) use ($user_id) {
			$q->where('user_id', $user_id);
		}, 'media', 'service_inclusions']);
		if (count($where) > 0)
			$services->where($where);
		$allServices = $services->paginate($item_per_page);
		if ($allServices->count() > 0)
			return $allServices;
		return false;
	}

	public function getService(array $where)
	{
		return $this->model->where($where)->first();
	}

	public function getAllService(array $where = [])
	{
		$service = $this->model;
		if (!empty($where)) {
			$service->where($where);
		}
		return $service->get();
	}

	public function getServices($user_ids, $item_per_page = null, array $where = [])
	{
		$services = $this->model->whereHas('user_services', function ($q) use ($user_ids) {
			$q->whereIn('user_id', $user_ids);
		})->with(['media', 'service_inclusions']);
		if (count($where) > 0)
			$services->where($where);
		if (is_null($item_per_page)) {
			$result = $services->get();
		} else {
			$result = $services->paginate($item_per_page);
		}
		if ($result->count() > 0)
			return $result;
		return false;
	}

	public function getVendorService($user_id, $service_id)
	{
		$services = $this->model->whereId($service_id)->whereHas('user_services', function ($q) use ($user_id) {
			$q->where('user_id', $user_id);
		})->with(['user_services' => function ($q) use ($user_id) {
			$q->where('user_id', $user_id);
		}, 'media', 'service_inclusions'])->first();
		if ($services)
			return $services;
		return false;
	}
}

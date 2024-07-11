<?php

namespace App\Repositories;

use App\Repositories\GenericRepository;
use App\Repositories\Interfaces\IServiceCategoryRepository;
use App\Models\ServiceCategory;

class ServiceCategoryRepository extends GenericRepository implements IServiceCategoryRepository
{
	public function model()
	{
		return ServiceCategory::class;
	}
	public function getServiceCategories(array $service_ids = [])
	{
		$all_categories = $this->model->has('service')->latest();
		if (empty($service_ids)) {
			return $all_categories->get();
		} else {
			return $this->model->whereIn('id', $service_ids)->latest()->get();
		}
	}
}

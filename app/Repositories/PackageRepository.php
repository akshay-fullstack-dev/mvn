<?php

namespace App\Repositories;

use App\Repositories\GenericRepository;
use App\Repositories\Interfaces\IPackageRepository;
use App\Models\Package;

class PackageRepository extends GenericRepository implements IPackageRepository
{
	public function model()
	{
		return Package::class;
	}
	public function get_active_package($timezone, $item_per_page)
	{
		return $this->model
			->activePackage($timezone)
			->whereHas('package_services')
			->with('package_services.service')
			->latest()->paginate($item_per_page);
	}
	public function getSingleActivePackage($package_id, $timezone)
	{
		return $this->model
			->activePackage($timezone)
			->whereHas('package_services')
			->with('package_services')
			->whereId($package_id)->first();
	}
}

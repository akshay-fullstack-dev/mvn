<?php

namespace App\Repositories\Interfaces;

interface IServiceRepository extends IGenericRepository
{
	public function getServices($active_vendor, $item_per_page = null);
}

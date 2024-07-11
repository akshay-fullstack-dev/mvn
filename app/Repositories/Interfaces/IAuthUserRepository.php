<?php

namespace App\Repositories\Interfaces;

interface IAuthUserRepository extends IGenericRepository
{
	public function get_user($where);
	public function getActiveVendorWithService($user_ids, $service_id, $item_per_page);
	public function getActiveVendor($user_ids, bool $shop_certified_vendor = false);
}

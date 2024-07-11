<?php

namespace App\Helpers\V1;

use App\Enum\UserEnum;


trait ServiceHelper
{

	public static function get_register_login_data($user_id, $request)
	{
		return [
			'user_id' => $user_id,
			'service_id' => $request->service_id,
			'price' => $request->vendor_price ?? "",
			'time' => $request->vendor_time ?? "",
		];
	}

	public static function getServiceRequestData($request)
	{
		return [
			'name' => $request->service_name,
			'service_category_id' => $request->category_id,
			'description' => $request->service_description ?? "",
			'price' => $request->service_price ?? null,
			'approx_time'  => $request->service_time ?? null,
			'approx_time'  => $request->service_time ?? null,
			'spare_parts'  => $request->spare_parts ?? null,
		];
	}

	public static function getInclusionDataFOrInsertion($whats_included)
	{
		$return_data = [];
		foreach ($whats_included as $inclusion) {
			$return_data[]['name'] = $inclusion;
		}
		return $return_data;
	}
}

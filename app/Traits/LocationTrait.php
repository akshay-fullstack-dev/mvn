<?php

namespace App\Traits;

use App\Enum\ShopEnum;
use App\Enum\UserEnum;
use App\Models\SparePartsShopLocation;
use App\Models\UserAddress;

trait LocationTrait
{
	private function getUserWithinRadius($latitude, $longitude, $finding_radius_in_km, $user_id = false, array $multiple_user_ids = [])
	{
		$address = UserAddress::whereHas('user', function ($q) {
			$q->stripeConnected();
		})->select(\DB::raw(" *, count(*) as cnt, ( 6371 * acos( cos( radians($latitude) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians( latitude ) ) ) ) AS distance "))
			->havingRaw('distance <= ' . $finding_radius_in_km);
		// check if certain user exists or not
		if ($user_id)
			$address->havingRaw('user_id = ' . $user_id);
		if (!empty($multiple_user_ids)) {
			$address->whereIn('user_id', $multiple_user_ids);
		}
		$userAddress = $address->groupBy("id")->get();

		if ($userAddress->count() > 0) {
			// return the user address if not found in the user address
			$home_address_user_id = [];
			$office_address_user_id = [];
			foreach ($userAddress as $address) {
				if ($address->type == UserEnum::USER_HOME_ADDRESS) {
					array_push($home_address_user_id, $address->user_id);
				} else {
					array_push($office_address_user_id, $address->user_id);
				}
			}
			return collect(array_unique(array_merge($office_address_user_id, $home_address_user_id)));
		} else {
			return false;
		}
	}

	public function get_location_distance($first_loc_latitude, $first_loc_longitude, $second_loc_latitude, $second_loc_longitude)
	{
		$rad = M_PI / 180;
		//Calculate distance from latitude and longitude
		$theta = $first_loc_longitude - $second_loc_longitude;
		$dist = sin($first_loc_latitude * $rad)
			* sin($second_loc_latitude * $rad) +  cos($first_loc_latitude * $rad)
			* cos($second_loc_latitude * $rad) * cos($theta * $rad);
		return acos($dist) / $rad * 60 *  1.853;
	}

	public function getShopWithInLocation($latitude, $longitude)
	{
		$finding_radius_in_km = ShopEnum::ShopSearchingRadius;
		$address = SparePartsShopLocation::select(\DB::raw(" *, count(*) as cnt, ( 6371 * acos( cos( radians($latitude) ) * cos( radians(`lat`) ) * cos( radians(`long`) - radians($longitude) ) + sin( radians($latitude) ) * sin(radians(`lat`) ) ) ) AS distance "))->orderBy('distance', 'ASC')
			->havingRaw('distance <= ' . $finding_radius_in_km);
		// check if certain user exists or not
		$userAddress = $address->groupBy("id")->get();
		if ($userAddress->count() > 0) {
			return $userAddress;
		} else {
			return false;
		}
	}

	public function getSpecificVendorLocation($userIds, $latitude, $longitude)
	{
	}
}

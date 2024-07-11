<?php

namespace App\Repositories;

use App\Enum\UserEnum;
use App\Helpers\V1\AuthHelper;
use App\Repositories\GenericRepository;
use App\Repositories\Interfaces\IAuthUserRepository;
use App\User;

class AuthUserRepository extends GenericRepository implements IAuthUserRepository
{
	public function model()
	{
		return User::class;
	}

	public function get_user($where)
	{
		return $this->model->where($where)->first();
	}
	public function updateUser($user, $updateData)
	{
		return $user->update($updateData);
	}

	public function updateOrCreateUserAddress($user, $insertUpdateData)
	{
		foreach ($insertUpdateData as $SingleData) {
			// return $user->user_verified_address()->;
		}
	}

	public function getActiveVendor($user_ids, bool $shop_certified_vendor = false)
	{
		$users = $this->model->whereIn('id', $user_ids)->activeVendor();
		if ($shop_certified_vendor)
			$users->where('admin_user', UserEnum::admin_user);
		else
			$users->where('admin_user', UserEnum::no_admin_user);
		$active_vendor = $users->get();
		if ($active_vendor->count() > 0)
			return $active_vendor;
		return false;
	}


	public function getActiveVendorWithService($user_ids, $service_id, $item_per_page, bool $not_shop_certified_vendor = true)
	{
		$active_users = $this->model->whereIn('id', $user_ids)
			->whereHas('vendor_services', function ($query) use ($service_id) {
				$query->whereService_id($service_id);
			})->with(['user_verified_address', 'vendor_services' => function ($query) use ($service_id) {
				$query->whereId($service_id)->first();
			}]);
		if ($not_shop_certified_vendor)
			$active_users->where('admin_user', UserEnum::no_admin_user);
		$active_users =	$active_users->paginate($item_per_page);
		if ($active_users->count() > 0)
			return $active_users;
		return false;
	}

	public function updateUserAddress($user, $address)
	{
		return $user->user_verified_address()->where('id', $address['address_id'])->update(AuthHelper::getUpdateAddress($address));
	}
	public function insertNewAddress($user, $address)
	{
		return $user->user_verified_address()->create(AuthHelper::getInsertAddress($address, $user->id));
	}

	// get certified vendor
	public function getCertifiedVendor()
	{
		$certified_vendor = $this->model->activeShopCertifiedVendor()->first();
		if ($certified_vendor)
			return $certified_vendor;
		return false;
	}

	public function checkVendor($vendor_id)
	{
		return $this->model->whereId($vendor_id)->stripeConnected()->activeUser()->online()->first();
	}
	public function user_verified_address($user_id , $address_id){
		

// dd($user_id);
       $userAddress_id = array();
		$verifyingAddress =  $this->model->with('user_verified_address')->where('id',$user_id)->get();
		
		foreach($verifyingAddress as $verify){

			foreach($verify->user_verified_address as $userAddress){
		             if($userAddress['id'] === $address_id){
						 return true;
					 }		
					 array_push($userAddress_id , $userAddress['id']);
				
			}
			return false;
                      
		}
			// dd($userAddress_id);
	}
}

<?php

namespace App\Services\Client;

use App\Enum\BookingEnum;
use App\Enum\UserEnum;
use App\Exceptions\BadRequestException;
use App\Exceptions\RecordNotFoundException;
use App\Http\Requests\V1\ClientRequests\Service;
use App\Models\DeliveryCharge;
use App\Repositories\Interfaces;
use App\Services\Interfaces\Client as IService;
use App\Traits\LangTrait;
use App\Traits\LocationTrait;

class ClientServices implements IService\IClientServices
{
	use LangTrait;
	use LocationTrait;
	private $lang = 'Api/v1/client/service';
	private $authRepository;
	private $serviceRepository;
	public function __construct(
		Interfaces\IServiceRepository $serviceRepository,
		Interfaces\IAuthUserRepository $authRepository
	) {
		$this->serviceRepository = $serviceRepository;
		$this->authRepository = $authRepository;
	}

	public function vendorNearby(Service\VendorNearbyRequest $request)
	{
		$searching_radius_in_km = UserEnum::NORMAL_VENDOR_SEARCHING_AREA_IN_KM;
		$item_per_page = $request->item_per_page ?? UserEnum::ITEM_PER_PAGE;
		$user_ids = $this->getUserWithinRadius($request->lat, $request->long, $searching_radius_in_km);
		if (!$user_ids)
			throw new BadRequestException($this->getMessage('vendor_not_found'));
		$active_vendors = $this->authRepository->getActiveVendorWithService($user_ids->unique(), $request->service_id, $item_per_page);
		if (!$active_vendors)
			throw new RecordNotFoundException($this->getMessage('vendor_not_found'));
		foreach ($active_vendors as $vendor) {
			$vendor->services = $this->serviceRepository->getVendorService($vendor->id, $request->service_id);
			$delivery_charges = DeliveryCharge::first();
			$vendor->delivery_price_per_km = $delivery_charges ? $delivery_charges->customer_delivery_charge : BookingEnum::DEFAULT_DELIVERY_CHARGES;
			$vendor_shop_address = $vendor->user_verified_address()->where('type', UserEnum::USER_OFFICE_ADDRESS)->first();
			$address_found = false;
			if ($vendor_shop_address) {
				$distance_between_user_and_vendor_in_km = $this->get_location_distance(
					$vendor_shop_address->latitude,
					$vendor_shop_address->longitude,
					$request->lat,
					$request->long
				);
				$address_found = true;
			}
			$vendor->delivery_charges = $address_found ? $this->calculate_vendor_delivery_charge($vendor, $distance_between_user_and_vendor_in_km) : 0;
			$vendor->distance_between_user_and_vendor_in_km = $address_found ? $distance_between_user_and_vendor_in_km : 0;
		}
		return $active_vendors;
	}


	// this function will get the service nearby the user according to the logged in user positional latitude and longitude
	public function serviceNearby(Service\ServiceNearbyRequest $request)
	{
		// if vendor is shop certified
		$item_per_page = $request->item_per_page ?? UserEnum::ITEM_PER_PAGE;
		$where = [];

		if ($request->category_id) {
			$where = ['service_category_id' => $request->category_id];
		}

		if ($request->vendor_type == UserEnum::SHOP_CERTIFIED_VENDOR) {
			// set range to certified vendor maximum
			$searching_radius_in_km = UserEnum::NORMAL_VENDOR_SEARCHING_AREA_IN_KM;
			// get certified vendor id for now only one vendor 
			$certified_vendor = $this->authRepository->getCertifiedVendor();
			if (!$certified_vendor)
				throw new BadRequestException($this->getMessage('no_service_found'));

			$user_ids = $this->getUserWithinRadius($request->lat, $request->long, $searching_radius_in_km, $certified_vendor->id);
			if (!$user_ids)
				throw new BadRequestException($this->getMessage('no_service_found'));

			$service_data = $this->serviceRepository->getEnrolledServices($certified_vendor->id, $item_per_page, $where);
			if (!$service_data)
				throw new RecordNotFoundException($this->getMessage('no_service_found'));

			// add service vendor id in response
			foreach ($service_data as $service)
				$service->shop_certified_vendor_id = $certified_vendor->id;
			return $service_data;
		} else {
			// SERVICE LISTING FOR THE NORMAL VENDORS
			$searching_radius_in_km = UserEnum::NORMAL_VENDOR_SEARCHING_AREA_IN_KM;
			$user_ids = $this->getUserWithinRadius($request->lat, $request->long, $searching_radius_in_km);
			if (!$user_ids)
				throw new BadRequestException($this->getMessage('no_service_found'));
			$active_vendor = $this->authRepository->getActiveVendor($user_ids->toArray());
			if (!$active_vendor)
				throw new RecordNotFoundException($this->getMessage('vendor_not_found'));
			$service = $this->serviceRepository->getServices($active_vendor->pluck('id')->toArray(), $item_per_page, $where);
			if (!$service)
				throw new RecordNotFoundException($this->getMessage('no_service_found'));
			return $service;
		}
	}

	public function getVendorServiceDetail(Service\VendorServiceDetailsRequest $request)
	{
		$vendor = $this->authRepository->get_user(['id' => $request->vendor_id]);
		if (!$vendor)
			throw new BadRequestException($this->getMessage('vendor_not_found'));
		$vendor_service = $this->serviceRepository->getVendorService($request->vendor_id, $request->service_id);
		if (!$vendor_service)
			throw new RecordNotFoundException($this->getMessage('no_service_found'));
		$delivery_charges = DeliveryCharge::first();
		$vendor->delivery_price_per_km = $delivery_charges ? $delivery_charges->customer_delivery_charge : BookingEnum::DEFAULT_DELIVERY_CHARGES;
		$vendor_shop_address = $vendor->user_verified_address()->where('type', UserEnum::USER_OFFICE_ADDRESS)->first();
		$distance_between_user_and_vendor_in_km = BookingEnum::DEFAULT_BOOKING_DISTANCE;
		if ($request->lat and $request->long) {
			$distance_between_user_and_vendor_in_km = $this->get_location_distance($vendor_shop_address->latitude, $vendor_shop_address->longitude, $request->lat, $request->long);
		}
		$vendor->delivery_charges = $this->calculate_vendor_delivery_charge($vendor, $distance_between_user_and_vendor_in_km);
		$vendor->distance_between_user_and_vendor_in_km = $distance_between_user_and_vendor_in_km;
		$vendor->services = $vendor_service;
		return $vendor;
	}

	private function calculate_vendor_delivery_charge($vendor, $distance)
	{
		return  round($vendor->delivery_price_per_km * $distance, 2);
	}
}

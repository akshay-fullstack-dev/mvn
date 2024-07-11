<?php

namespace App\Services;

use App\Enum\ServiceEnum;
use App\Enum\UserEnum;
use App\Exceptions\BadRequestException;
use App\Exceptions\RecordNotFoundException;
use App\Helpers\V1\ServiceHelper;
use App\Http\Requests\V1\Service\GetServiceRequest;
use App\Http\Requests\V1\Service\RequestNewServiceRequest;
use App\Http\Requests\V1\Service\ServiceCategoriesRequest;
use App\Repositories\Interfaces\IAuthUserRepository;
use App\Repositories\Interfaces\IServiceCategoryRepository;
use App\Services\Interfaces\IServicesServices;
use App\Repositories\Interfaces\IServiceRepository;
use App\Repositories\Interfaces\IUserServiceRepository;
use App\Traits\LangTrait;
use App\Traits\LocationTrait;
use Illuminate\Support\Facades\Auth;

class ServicesServices implements IServicesServices
{
	use LocationTrait;
	use LangTrait;
	private $serviceRepository;
	private $userServiceRepository;
	private $serviceCategoryRepository;
	private $lang = 'Api/v1/service';

	public function __construct(
		IServiceRepository $serviceRepository,
		IAuthUserRepository $authRepository,
		IUserServiceRepository $userServiceRepository,
		IServiceCategoryRepository $serviceCategoryRepository
	) {
		$this->serviceRepository = $serviceRepository;
		$this->userServiceRepository = $userServiceRepository;
		$this->authRepository = $authRepository;
		$this->serviceCategoryRepository = $serviceCategoryRepository;
	}
	// save the device details
	public function getServices(GetServiceRequest $request)
	{
		$user = Auth::user();
		$item_per_page = $request->item_per_page ?? ServiceEnum::record_per_page;
		$where = [];
		if ($request->category_id) {
			$where = ['service_category_id' => $request->category_id];
		}
		if ($request->enrolled == ServiceEnum::enrolled) {
			$service_data = $this->serviceRepository->getEnrolledServices($user->id, $item_per_page, $where);
		} else {
			$service_data = $this->serviceRepository->getServiceWithoutEnrolled($user->id, $item_per_page, $where);
		}
		if (!$service_data)
			throw new RecordNotFoundException(trans('Api/v1/service.services_not_found'));
		return $service_data;
	}

	public function enrollService($request)
	{
		$user = Auth::user();
		$service = $this->serviceRepository->find($request->service_id);
		$userService = $this->userServiceRepository->getUserService(['service_id' => $request->service_id, 'user_id' => $user->id]);
		if ($userService)
			throw new BadRequestException(trans('Api/v1/service.already_subscribed_this_service'));
		if ((float)$request->vendor_price > (float)$service->price)
			throw new BadRequestException(trans('Api/v1/service.requested_price_should_not_greater_than_actual_service_price'));
		$insert_data = ServiceHelper::get_register_login_data($user->id, $request);
		$this->userServiceRepository->create($insert_data);
		return trans('Api/v1/service.successfully_enroll_service');
	}

	public function removeService($request)
	{
		$user = Auth::user();
		$userService = $this->userServiceRepository->getUserService(['service_id' => $request->service_id, 'user_id' => $user->id]);
		if (!$userService)
			throw new BadRequestException(trans('Api/v1/service.not_subscribed_to_this_service'));
		$userService->delete();
		return trans('Api/v1/service.successfully_deleted_this_service');
	}

	public function setServicePrice($request)
	{
		$user = Auth::user();
		$userService = $this->userServiceRepository->getUserService(['service_id' => $request->service_id, 'user_id' => $user->id]);
		if (!$userService)
			throw new BadRequestException(trans('Api/v1/service.not_subscribed_to_this_service'));
		$service = $this->serviceRepository->find($request->service_id);
		if ((float)$request->price > (float)$service->price) {
			throw new BadRequestException(trans('Api/v1/service.requested_price_should_not_greater_than_actual_service_price'));
		}
		$userService->price = $request->price;
		$userService->save();
		return trans('Api/v1/service.successfully_added_price_to_service');
	}

	public function setServiceTime($request)
	{
		$user = Auth::user();
		$userService = $this->userServiceRepository->getUserService(['service_id' => $request->service_id, 'user_id' => $user->id]);
		if (!$userService)
			throw new BadRequestException(trans('Api/v1/service.not_subscribed_to_this_service'));
		$userService->time = $request->time;
		$userService->save();
		return trans('Api/v1/service.service_time_set_successfully');
	}

	public function requestNewService(RequestNewServiceRequest $request)
	{
		$user = Auth::user();
		$service = $this->serviceRepository->getService(['name' => $request->service_name]);
		if ($service)
			throw new BadRequestException(trans('Api/v1/service.service_already_exist_with_this'));
		$new_service = $user->vendor_requested_new_service()->where('name', $request->service_name)->first();
		if ($new_service) {
			throw new BadRequestException(trans('Api/v1/service.service_request_already_send_to_admin'));
		}

		$newService = $user->vendor_requested_new_service()->create(ServiceHelper::getServiceRequestData($request, $user->id));
		if ($request->whats_included and !empty($request->whats_included))
			$newService->service_inclusion()->createMany(ServiceHelper::getInclusionDataFOrInsertion($request->whats_included));
		if ($request->service_images and !empty($request->service_images))
			$this->uploadRequestedServiceImages($request->service_images,	$newService);
		return trans('Api/v1/service.service_new_request_send_successfully');
	}

	private function uploadRequestedServiceImages(array $service_images, $new_service): void
	{
		foreach ($service_images as $image) {
			$new_service->addMediaFromUrl($image)->toMediaCollection();
		}
	}

	public function getServiceCategories(ServiceCategoriesRequest $request)
	{
		$searching_radius_in_km = UserEnum::NORMAL_VENDOR_SEARCHING_AREA_IN_KM;
		$auth_user = Auth::user();
		// if user is logged in then we need to show the category on the location based within a particular radius  
		$admin_vendor_id = false;
		if ($auth_user->role == UserEnum::user_customer) {
			if ($request->vendor_type == UserEnum::SHOP_CERTIFIED_VENDOR_REQUEST) {
				$admin_user = $this->authRepository->get_user(['admin_user' => UserEnum::admin_user]);
				if (!$admin_user) {
					throw new BadRequestException($this->getMessage('not_category_found'));
				}
				$admin_vendor_id = $admin_user->id;
			}
			$user_ids = $this->getUserWithinRadius($request->lat, $request->long, $searching_radius_in_km, $admin_vendor_id);
			if (!$user_ids)
				throw new BadRequestException($this->getMessage('not_category_found'));
			$active_vendor = $this->authRepository->getActiveVendor($user_ids, $admin_vendor_id);
			if (!$active_vendor)
				throw new RecordNotFoundException($this->getMessage('not_category_found'));
			$service = $this->serviceRepository->getServices($active_vendor->pluck('id')->toArray());
			if (!$service)
				throw new RecordNotFoundException($this->getMessage('not_category_found'));
			$all_service = $service->pluck('service_category_id')->unique()->toArray();
			$service_category = $this->serviceCategoryRepository->getServiceCategories($all_service);
			if (!$service_category->count() > 0)
				throw new RecordNotFoundException($this->getMessage('not_category_found'));
			return $service_category;
		} else {
			$all_service = $this->serviceRepository->getAllService();
			if (!$all_service->count() > 0)
				throw new RecordNotFoundException($this->getMessage('not_category_found'));
			$service_category = $this->serviceCategoryRepository->getServiceCategories($all_service->pluck('service_category_id')->toArray());
			if (!$service_category->count() > 0)
				throw new RecordNotFoundException($this->getMessage('not_category_found'));
			return $service_category;
		}
	}
}

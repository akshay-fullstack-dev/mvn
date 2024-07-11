<?php

namespace App\Traits\V1;

use App\Http\Requests\V1\Service;
use App\Http\Requests\V1\Service\ServiceCategoriesRequest;
use App\Services\Interfaces\IServicesServices;

trait ServiceActions
{
	private $serviceService;

	public function __construct(IServicesServices  $serviceService)
	{
		$this->serviceService = $serviceService;
	}
	public function getServices(Service\GetServiceRequest $request)
	{
		return $this->serviceService->getServices($request);
	}
	public function enrollService(Service\EnrollServiceRequest $request)
	{
		return $this->serviceService->enrollService($request);
	}
	public function removeService(Service\DeleteServiceRequest $request)
	{
		return $this->serviceService->removeService($request);
	}
	public function setServicePrice(Service\SetServicePriceRequest $request)
	{
		return $this->serviceService->setServicePrice($request);
	}

	public function setServiceTime(Service\SetServiceTimeRequest $request)
	{
		return $this->serviceService->setServiceTime($request);
	}
	public function requestNewService(Service\RequestNewServiceRequest $request)
	{
		return $this->serviceService->requestNewService($request);
	}
	public function serviceCategory(ServiceCategoriesRequest $request)
	{
		return $this->serviceService->getServiceCategories($request);
	}
}

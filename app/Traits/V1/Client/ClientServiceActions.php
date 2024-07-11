<?php

namespace App\Traits\V1\Client;

use App\Services\Interfaces\Client\IClientServices;
use App\Http\Requests\V1\ClientRequests\Service;

trait ClientServiceActions
{
	private $authService;

	public function __construct(IClientServices  $clientService)
	{
		$this->clientService = $clientService;
	}
	public function vendorsNearby(Service\VendorNearbyRequest $request)
	{
		return $this->clientService->vendorNearby($request);
	}
	public function serviceNearby(Service\ServiceNearbyRequest $request)
	{
		return $this->clientService->serviceNearby($request);
	}
	public function getVendorServiceDetail(Service\VendorServiceDetailsRequest $request)
	{
		return $this->clientService->getVendorServiceDetail($request);
	}
}

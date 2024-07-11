<?php

namespace App\Services\Interfaces;

use App\Http\Requests\V1\Service\GetServiceRequest;

interface IServicesServices
{
	public function getServices(GetServiceRequest $request);
}

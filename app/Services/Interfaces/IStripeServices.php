<?php

namespace App\Services\Interfaces;

use App\Http\Requests\V1\Service\GetServiceRequest;
use App\Http\Requests\V1\Stripe\AddMoneyRequest;

interface IStripeServices
{
	public function addMoney(AddMoneyRequest $request);
}

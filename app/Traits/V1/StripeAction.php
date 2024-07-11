<?php

namespace App\Traits\V1;

use App\Http\Requests\V1\Stripe\AddMoneyRequest;
use App\Services\Interfaces\IStripeServices;

trait StripeAction
{
	private $stripeService;

	public function __construct(IStripeServices  $stripeService)
	{
		$this->stripeService = $stripeService;
	}

	public function addMoney(AddMoneyRequest $request)
	{
		return $this->stripeService->addMoney($request);
	}
}

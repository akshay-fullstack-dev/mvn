<?php

namespace App\Traits\V1;

use App\Http\Requests\V1\Common\RaiseDisputeRequest;
use App\Services\Interfaces\ICommonService;
use Illuminate\Http\Request;

trait CommonAction
{
	private $commonService;

	public function __construct(ICommonService  $commonService)
	{
		$this->commonService = $commonService;
	}

	public function getReferralPrice()
	{
		return $this->commonService->getReferralPrice();
	}
	public function raiseDispute(RaiseDisputeRequest $raiseDisputeRequest)
	{
		return $this->commonService->raiseDispute($raiseDisputeRequest);
	}
	public function getDispute(Request $request)
	{
		return $this->commonService->getDispute($request);
	}
}

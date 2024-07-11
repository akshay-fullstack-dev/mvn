<?php

namespace App\Traits\V1;

use App\Http\Requests\V1\Coupon\GetCouponRequest;
use App\Services\Interfaces\ICouponServices;


trait CouponAction
{
	private $couponServices;

	public function __construct(ICouponServices  $couponServices)
	{
		$this->couponServices = $couponServices;
	}
	public function getCoupons(GetCouponRequest $request)
	{
		return 	$this->couponServices->getCoupons($request);
	}
}

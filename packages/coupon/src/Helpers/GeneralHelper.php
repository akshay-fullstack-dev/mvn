<?php

namespace IntersoftCoupon\Helpers;

use Illuminate\Support\Str;

class GeneralHelper
{
	const referral_code_length = 6;
	const coupon_code_length = 6;
	public static function getReferralCode($is_static = false)
	{
		if ($is_static)
			return 'aaaaaa';
		return Str::random(GeneralHelper::referral_code_length);
	}
	public static function getCouponCode($is_static = false)
	{
		if ($is_static)
			return 'aaaaaa';
		return Str::random(GeneralHelper::coupon_code_length);
	}
}

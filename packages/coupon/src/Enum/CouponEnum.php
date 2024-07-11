<?php

namespace IntersoftCoupon\Enum;

class CouponEnum
{
	const COUPON_TYPE_PERCENTAGE = 0;
	const COUPON_TYPE_FIXED = 1;

	const COUPON_DISCOUNT_VALUE = 20;

	const MAXIMUM_REFERRAL_COUPON_USE_PER_USER = 1;
	const MAXIMUM_REFERRAL_COUPON_USE = 1;

	const REFERRAL_COUPON_EXPIRY_YEAR = 5;
	const REFERRAL_COUPON_MIN_AMOUNT = 200;
	const REFERRAL_COUPON_MAX_AMOUNT = 800;
	const PAGINATION_ITEM_PER_PAGE = 25;
}

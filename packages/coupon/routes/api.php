<?php

use IntersoftCoupon\Http\Controllers\CouponPackageController;

Route::prefix('api')->group(function () {
	Route::get('get-coupons', CouponPackageController::class . '@getCoupons');
});
// middleware('auth:api')->
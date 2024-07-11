<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->namespace('v1')->group(function () {
	Route::get('get-coupons', 'CouponsController@getCoupons');
});

<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->namespace('v1')->group(function () {
	Route::post('add-money', 'StripeController@addMoney');
});

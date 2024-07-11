<?php

use Illuminate\Support\Facades\Route;

Route::namespace('v1')->group(function () {
	Route::middleware('auth:api')->group(function () {
		Route::get('services', 'ServiceController@getServices');
		Route::post('enroll-service', 'ServiceController@enrollService');
		Route::post('remove-service', 'ServiceController@removeService');
		Route::post('set-service-price', 'ServiceController@setServicePrice');
		Route::post('set-service-time', 'ServiceController@setServiceTime');
		Route::post('request-new-service', 'ServiceController@requestNewService');
		Route::get('service-category', 'ServiceController@serviceCategory');
	});
});

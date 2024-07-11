<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->namespace('v1')->group(function () {
	Route::get('get-vehicle-company', 'VehicleController@getVehicleCompany');
	Route::get('get-company-models', 'VehicleController@getCompanyModel');
	Route::post('add-vehicle', 'VehicleController@addVehicle');
	Route::post('delete-vehicle', 'VehicleController@deleteVehicle');
	Route::get('get-user-vehicle', 'VehicleController@getUserVehicle');
	Route::post('update-user-vehicle', 'VehicleController@updateUserVehicle');
});

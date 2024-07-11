<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1', 'middleware' => 'auth:api', 'namespace' => 'IntersoftStripe\Http\Controllers'], function () {
    Route::get('accountLinked', 'StripeController@accountLinked');
    Route::get('customerExists', 'StripeController@customerExists');
    Route::post('linkAccount', 'StripeController@linkAccount');
    Route::post('createCustomer', 'StripeController@createCustomer');
});

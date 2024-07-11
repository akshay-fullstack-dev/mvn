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


Route::namespace('v1')->group(function () {
    Route::post('app_version', 'AppVersionController@appVersion');
    Route::get('get-referral-amount', 'CommonApiController@getReferralPrice');

    Route::middleware('auth:api')->group(function () {
        Route::post('raise-dispute', 'CommonApiController@raiseDispute');
        Route::get('list-dispute', 'CommonApiController@getDispute');
    });
});

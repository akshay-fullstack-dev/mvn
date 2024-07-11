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
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('v1')->group(function () {
    Route::post('register', 'AuthController@register');
    Route::post('send-otp', 'AuthController@sendOtp');
    Route::post('verify-otp', 'AuthController@verifyOtp');
    Route::post('login', 'AuthController@login');
    Route::post('check-user', 'AuthController@checkUser');
    
    // these api will hit if user is logged in . fi user not logged in then these api's are not accessible
    Route::middleware('auth:api')->group(function () {
        Route::get('logout', 'AuthController@logoutUser');
        Route::post('delete-address', 'AuthController@deleteAddress');
        // only on blocked user can access these routes
        Route::middleware('check_blocked')->group(function () {
            Route::get('profile', 'AuthController@profile');
            Route::post('change-email', 'AuthController@changeEmail');
            // upload user documents
            Route::post('upload-document', 'AuthController@uploadDocument');
            Route::post('update-profile', 'AuthController@sendProfileChangeRequest');
            Route::post('update-phone-number', 'AuthController@changePhoneNumber');
            Route::post('update-profile-image', 'AuthController@changeProfileImage');
            Route::get('change-status', 'AuthController@changeStatus');
            Route::post('update-location', 'AuthController@updateLocation');
        });
    });
});

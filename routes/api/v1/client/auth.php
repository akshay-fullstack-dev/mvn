<?php
Route::post('register', 'AuthController@register');
Route::post('social-login', 'AuthController@socialLogin');
Route::post('login', 'AuthController@login');
Route::post('forgot-password', 'AuthController@forgotPassword');

Route::middleware('auth:api')->group(function () {
	Route::post('change-password', 'AuthController@changePassword');
});

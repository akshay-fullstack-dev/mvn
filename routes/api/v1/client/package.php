<?php
Route::get('/', 'PackageController@index');


Route::middleware('auth:api')->group(function () {
    Route::post('book-package', 'PackageController@bookPackage');
    Route::get('/list-book-package', 'PackageController@getUserAllPurchasedPackageList');
    Route::post('cancel-bookings','PackageController@cancelBooking');
});

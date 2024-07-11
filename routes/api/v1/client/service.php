<?php


Route::get('vendors-nearby', 'ServiceController@vendorsNearby');
Route::get('service-nearby', 'ServiceController@serviceNearby');
Route::get('vendor-service-detail', 'ServiceController@getVendorServiceDetail');
Route::middleware('auth:api')->group(function () {
	Route::post('book-service', 'BookingController@bookService');
	// get-booking-detail :- This api is used for both user and vendor end
	Route::get('get-booking-detail', 'BookingController@getBookingDetail');
	Route::post('check-vendor-availability', 'BookingController@checkVendorAvailability');
	Route::get('get-booking-history', 'BookingController@getBookingHistory');
	Route::get('get-vendor-location', 'BookingController@getVendorLocation');
	Route::post('reschedule-booking', 'BookingController@rescheduleBooking');
});

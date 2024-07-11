<?php
Route::namespace('v1')->middleware('auth:api')->group(function () {
	Route::middleware('is_vendor')->group(function () {
		Route::get('booking-history', 'BookingController@getVendorBookingHistory');
		Route::post('upload-bills', 'BookingController@uploadBills');
		Route::post('booking-action', 'BookingController@bookingAction');
		Route::get('get-all-completed-bookings', 'BookingController@getAllCompletedBookings');
	});
	Route::post('change-booking-status', 'BookingController@changeBookingStatus');
});

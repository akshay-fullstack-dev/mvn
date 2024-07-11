<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('welcome');
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('admin-users')->name('admin-users/')->group(static function () {
            Route::get('/',                                             'AdminUsersController@index')->name('index');
            Route::get('/create',                                       'AdminUsersController@create')->name('create');
            Route::post('/',                                            'AdminUsersController@store')->name('store');
            Route::get('/{adminUser}/impersonal-login',                 'AdminUsersController@impersonalLogin')->name('impersonal-login');
            Route::get('/{adminUser}/edit',                             'AdminUsersController@edit')->name('edit');
            Route::post('/{adminUser}',                                 'AdminUsersController@update')->name('update');
            Route::delete('/{adminUser}',                               'AdminUsersController@destroy')->name('destroy');
            Route::get('/{adminUser}/resend-activation',                'AdminUsersController@resendActivationEmail')->name('resendActivationEmail');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::get('/profile',                                      'ProfileController@editProfile')->name('edit-profile');
        Route::post('/profile',                                     'ProfileController@updateProfile')->name('update-profile');
        Route::get('/password',                                     'ProfileController@editPassword')->name('edit-password');
        Route::post('/password',                                    'ProfileController@updatePassword')->name('update-password');
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('users')->name('users/')->group(static function () {
            Route::get('/',                                             'UsersController@index')->name('index');
            Route::get('/create',                                       'UsersController@create')->name('create');
            Route::post('/',                                            'UsersController@store')->name('store');
            Route::get('/{user}/edit',                                  'UsersController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'UsersController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{user}',                                      'UsersController@update')->name('update');
            Route::delete('/{user}',                                    'UsersController@destroy')->name('destroy');
            Route::get('/{user}/viewDetails',                           'UsersController@viewDetails')->name('viewDetails');
            Route::get('/{user}/showReason',                           'UsersController@showReason')->name('showReason');
            Route::post('/{user}/featured',                          'UsersController@featured')->name('featured');
            Route::get('/block',                                       'UsersController@block')->name('block');
            Route::get('/approve',                                       'UsersController@approve')->name('approve');
            Route::get('/reject',                                       'UsersController@reject')->name('reject');
            Route::get('/{user}/showDocument',                           'UsersController@showDocument')->name('showDocument');
            Route::get('/{user}/enrollService',                          'UsersController@enrollService')->name('enrollService');
            Route::get('/{user}/bookings',                              'UsersController@bookings')->name('bookings');
            Route::get('/{user}/userBookings',                              'UsersController@userBookings')->name('userBookings');
            Route::get('/{user}/userVehicles',                              'UsersController@userVehicles')->name('userVehicles');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('user-documents')->name('user-documents/')->group(static function () {
            Route::get('/',                                             'UserDocumentsController@index')->name('index');
            Route::get('/create',                                       'UserDocumentsController@create')->name('create');
            Route::post('/',                                            'UserDocumentsController@store')->name('store');
            Route::get('/{userDocument}/edit',                          'UserDocumentsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'UserDocumentsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{userDocument}',                              'UserDocumentsController@update')->name('update');
            Route::delete('/{userDocument}',                            'UserDocumentsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('user-documents')->name('user-documents/')->group(static function () {
            Route::get('/',                                             'UserDocumentsController@index')->name('index');
            Route::get('/create',                                       'UserDocumentsController@create')->name('create');
            Route::post('/',                                            'UserDocumentsController@store')->name('store');
            Route::get('/{userDocument}/edit',                          'UserDocumentsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'UserDocumentsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{userDocument}',                              'UserDocumentsController@update')->name('update');
            Route::delete('/{userDocument}',                            'UserDocumentsController@destroy')->name('destroy');
        });
    });
});




/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('services')->name('services/')->group(static function () {
            Route::get('/',                                             'ServicesController@index')->name('index');
            Route::get('/create',                                       'ServicesController@create')->name('create');
            Route::get('/{id}/show',                                    'ServicesController@show')->name('show');
            Route::post('/',                                            'ServicesController@store')->name('store');
            Route::get('/{service}/edit',                               'ServicesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ServicesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{service}',                                   'ServicesController@update')->name('update');
            Route::delete('/{service}',                                 'ServicesController@destroy')->name('destroy');
            Route::get('/{service}/view',                               'ServicesController@view_cont')->name('view ');
        });
    });
});




/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('vendor-requested-services')->name('vendor-requested-services/')->group(static function () {
            Route::get('/',                                             'VendorRequestedServicesController@index')->name('index');
            Route::get('/create',                                       'VendorRequestedServicesController@create')->name('create');
            Route::post('/',                                            'VendorRequestedServicesController@store')->name('store');
            Route::get('/{vendorRequestedService}/edit',                'VendorRequestedServicesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'VendorRequestedServicesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{vendorRequestedService}',                    'VendorRequestedServicesController@update')->name('update');
            Route::delete('/{vendorRequestedService}',                  'VendorRequestedServicesController@destroy')->name('destroy');
            Route::get('/approve',                                      'VendorRequestedServicesController@approve')->name('approve');
            Route::get('/disapprove',                                   'VendorRequestedServicesController@disapprove')->name('disapprove');
        });
    });
});
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('customer')->name('customer/')->group(static function () {
            Route::get('/', 'UsersController@customerIndex')->name('customerIndex');
            Route::get('/{user}/viewDetails', 'UsersController@viewDetails')->name('viewDetails');
            Route::get('/{user}/userVehicles', 'UsersController@userVehicles')->name('userVehicles');
            Route::get('/{user}/userBookings', 'UsersController@userBookings')->name('userBookings');
        });
    });
});


// // upload the file from the admin
// Route::post('upload', function (Request $request) {
//     if ($request->hasFile('file')) {
//         return ['path' => 'https://mvm-test-images.s3.ap-south-1.amazonaws.com/1603810341starry_sky_silhouette_swing_tree_night_118434_1920x1080.jpg'];
//         $file = $request->file('file');
//         $filename = time() . $file->getClientOriginalName();
//         //store url
//         $storagePath = Storage::disk('s3')->put($filename, file_get_contents($file));
//         $path = Storage::disk('s3')->url($filename);
//         echo $path;die;
//         return response()->json(['path' => $path], 200);
//     }
//     return response()->json(trans('brackets/media::media.file.not_provided'), 422);
// })->name('brackets/media::upload');


// upload the file from the admin
Route::post('upload', function (Request $request) {
    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $filename = time() . '.' . $request->file->extension();
        //store url

        $storagePath = Storage::disk('s3')->put($filename, file_get_contents($file));
        $path = Storage::disk('s3')->url($filename);
        return response()->json(['path' => $path], 200);
    }
    return response()->json(trans('brackets/media::media.file.not_provided'), 422);
})->name('brackets/media::upload');


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('coupons')->name('coupons/')->group(static function () {
            Route::get('/',                                             'CouponsController@index')->name('index');
            Route::get('/create',                                       'CouponsController@create')->name('create');
            Route::post('/',                                            'CouponsController@store')->name('store');
            Route::get('/{coupon}/edit',                                'CouponsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'CouponsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{coupon}',                                    'CouponsController@update')->name('update');
            Route::delete('/{coupon}',                                  'CouponsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('delivery-charges')->name('delivery-charges/')->group(static function () {
            Route::get('/',                                             'DeliveryChargesController@index')->name('index');
            Route::get('/create',                                       'DeliveryChargesController@create')->name('create');
            Route::post('/',                                            'DeliveryChargesController@store')->name('store');
            Route::get('/{deliveryCharge}/edit',                        'DeliveryChargesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'DeliveryChargesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{deliveryCharge}',                            'DeliveryChargesController@update')->name('update');
            Route::delete('/{deliveryCharge}',                          'DeliveryChargesController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('bookings')->name('bookings/')->group(static function () {
            // Route::get('/',                                             'BookingsController@index')->name('index');
            Route::get('/create',                                       'BookingsController@create')->name('create');
            Route::post('/',                                            'BookingsController@store')->name('store');
            Route::get('/{booking}/edit',                               'BookingsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'BookingsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{booking}',                                   'BookingsController@update')->name('update');
            Route::delete('/{booking}',                                 'BookingsController@destroy')->name('destroy');
            Route::get('/{booking}/view',                               'BookingsController@view')->name('view');
            Route::get('/',                                 'BookingsController@selectedShop')->name('index');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('app-packages')->name('app-packages/')->group(static function () {
            Route::get('/',                                             'AppPackagesController@index')->name('index');
            Route::get('/create',                                       'AppPackagesController@create')->name('create');
            Route::post('/',                                            'AppPackagesController@store')->name('store');
            Route::get('/{appPackage}/edit',                            'AppPackagesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'AppPackagesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{appPackage}',                                'AppPackagesController@update')->name('update');
            Route::delete('/{appPackage}',                              'AppPackagesController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('app-versions')->name('app-versions/')->group(static function () {
            Route::get('/',                                             'AppVersionsController@index')->name('index');
            Route::get('/create',                                       'AppVersionsController@create')->name('create');
            Route::post('/',                                            'AppVersionsController@store')->name('store');
            Route::get('/{appVersion}/edit',                            'AppVersionsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'AppVersionsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{appVersion}',                                'AppVersionsController@update')->name('update');
            Route::delete('/{appVersion}',                              'AppVersionsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('service-categories')->name('service-categories/')->group(static function () {
            Route::get('/',                                             'ServiceCategoryController@index')->name('index');
            Route::get('/create',                                       'ServiceCategoryController@create')->name('create');
            Route::post('/',                                            'ServiceCategoryController@store')->name('store');
            Route::get('/{serviceCategory}/edit',                       'ServiceCategoryController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ServiceCategoryController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{serviceCategory}',                           'ServiceCategoryController@update')->name('update');
            Route::delete('/{serviceCategory}',                         'ServiceCategoryController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('spare-parts-shop-locations')->name('spare-parts-shop-locations/')->group(static function () {
            Route::get('/',                                             'SparePartsShopLocationsController@index')->name('index');
            Route::get('/create',                                       'SparePartsShopLocationsController@create')->name('create');
            Route::post('/',                                            'SparePartsShopLocationsController@store')->name('store');
            Route::get('/{sparePartsShopLocation}/edit',                'SparePartsShopLocationsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'SparePartsShopLocationsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{sparePartsShopLocation}',                    'SparePartsShopLocationsController@update')->name('update');
            Route::delete('/{sparePartsShopLocation}',                  'SparePartsShopLocationsController@destroy')->name('destroy');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('referral-amounts')->name('referral-amounts/')->group(static function () {
            Route::get('/',                                             'ReferralAmountsController@index')->name('index');
            Route::get('/create',                                       'ReferralAmountsController@create')->name('create');
            Route::post('/',                                            'ReferralAmountsController@store')->name('store');
            Route::get('/{referralAmount}/edit',                        'ReferralAmountsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ReferralAmountsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{referralAmount}',                            'ReferralAmountsController@update')->name('update');
            Route::delete('/{referralAmount}',                          'ReferralAmountsController@destroy')->name('destroy');
        });
    });
});
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->prefix('admin')->namespace('Admin')->name('admin/')->group(function () {
    Route::get('my-earnings', 'EarningController@index')->name('index');
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('disputes')->name('disputes/')->group(static function () {
            Route::get('/',                                             'DisputesController@index')->name('index');
            Route::get('/create',                                       'DisputesController@create')->name('create');
            Route::post('/',                                            'DisputesController@store')->name('store');
            Route::get('/{dispute}/edit',                               'DisputesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'DisputesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{dispute}',                                   'DisputesController@update')->name('update');
            Route::delete('/{dispute}',                                 'DisputesController@destroy')->name('destroy');
            Route::post('/{dispute}/change-status',                                 'DisputesController@changeStatus')->name('change-status');
            Route::get('change-resolve-status', 'DisputesController@changeResolveStatusStatus')->name('change-resolve-status');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('packages')->name('packages/')->group(static function () {
            Route::get('/',                                             'PackagesController@index')->name('index');
            Route::get('/create',                                       'PackagesController@create')->name('create');
            Route::post('/',                                            'PackagesController@store')->name('store');
            Route::get('/{package}/edit',                               'PackagesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'PackagesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{package}',                                   'PackagesController@update')->name('update');
            Route::delete('/{package}',                                 'PackagesController@destroy')->name('destroy');
            Route::get('/book-package',                                 'PackagesController@getBookedPackage')->name('getBookedPackage');
            Route::get('/book/view/{id}',                              'PackagesController@bookViewReturn')->name('bookViewReturn');
            Route::get('/book/{id}/edit',                              'PackagesController@bookEditReturn')->name('bookEditReturn');
            Route::get('/bookings/{package_id}',                       'PackagesController@packageBooking')->name('package-bookings');
            Route::get('/order-bookings/{order_id}',                   'PackagesController@bookingsByOrderId')->name('order-bookings');
            Route::get('/get-booking-vendor/{booking_id}',             'PackagesController@getBookingVendor');
            Route::get('assign-vendor',                               'PackagesController@assignVendor');
        });
    });
});

// common routes
Route::prefix('admin')->namespace('Admin')->group(function () {
    Route::post('filter_services',                                 'PackagesController@get_filter_bookings')->name('services');
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('package-maintains')->name('package-maintains/')->group(static function () {
            Route::get('/',                                             'PackageMaintainsController@index')->name('index');
            Route::get('/create',                                       'PackageMaintainsController@create')->name('create');
            Route::post('/',                                            'PackageMaintainsController@store')->name('store');
            Route::get('/{packageMaintain}/edit',                       'PackageMaintainsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'PackageMaintainsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{packageMaintain}',                           'PackageMaintainsController@update')->name('update');
            Route::delete('/{packageMaintain}',                         'PackageMaintainsController@destroy')->name('destroy');
        });
    });
});

<?php

use App\Enum\BookingEnum;
use App\Enum\UserEnum;
use App\Models\Booking;
use App\Models\BookingPayment;
use App\Repositories\Interfaces\IOtpRepository;
use App\Services\OtpServices;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Route;
use IntersoftStripe\Http\Services\StripePaymentProcess;


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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/test-function', 'TestController@testFunction');
/**
 * This api is used to transfer the amount to specified account
 */
Route::get('test', function () {
    $s3 = Storage::disk('s3')->getAdapter()->getClient();
    echo $s3->getObjectUrl(env('AWS_BUCKET'), '1613135001.png');die;
});

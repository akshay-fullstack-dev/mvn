<?php

namespace App\Http\Controllers\v1\Client;

use App\Http\Controllers\Controller;
use App\Traits\V1\BookingAction;
use Illuminate\Http\Request;

class BookingController extends Controller
{
	use BookingAction;
}

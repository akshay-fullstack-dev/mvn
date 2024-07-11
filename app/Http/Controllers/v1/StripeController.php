<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;

use App\Traits\V1\StripeAction;

class StripeController extends Controller
{
    use StripeAction;
}

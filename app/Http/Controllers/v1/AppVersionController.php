<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;

use App\Traits\V1\VersionAction;

class AppVersionController extends Controller
{
    use VersionAction;
}

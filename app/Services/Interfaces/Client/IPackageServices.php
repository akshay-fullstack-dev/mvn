<?php

namespace App\Services\Interfaces\Client;

use App\Http\Requests\V1\ClientRequests\Package\PackageListRequest;

interface IPackageServices
{
	public function index(PackageListRequest $request);

}

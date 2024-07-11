<?php

namespace App\Services;

use App\Exceptions\RecordNotFoundException;
use App\Models\AppPackage;
use App\Models\AppVersion;
use App\Services\Interfaces\IVersionService;



class VersionService implements IVersionService
{
	public function appVersion($request)
	{
		$package = AppPackage::where('bundle_id', $request->bundle_id)->first();
		$app_version = AppVersion::where('platform', $request->platform)->latest()->with('app_packages')->where('app_package_id', $package->id)->first();
		if (!$app_version)
			throw new RecordNotFoundException('Record not found');
		return $app_version;
	}
}

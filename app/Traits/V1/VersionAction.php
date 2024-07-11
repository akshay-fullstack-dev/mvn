<?php

namespace App\Traits\V1;

use App\Http\Requests\V1\AppVersion\GetAppVersionRequest;
use App\Services\Interfaces\IVersionService;

trait VersionAction
{
	private $versionService;

	public function __construct(IVersionService  $versionService)
	{
		$this->versionService = $versionService;
	}
	public function appVersion(GetAppVersionRequest $request)
	{
		return 	$this->versionService->appVersion($request);
	}
}

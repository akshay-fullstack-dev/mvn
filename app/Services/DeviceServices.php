<?php

namespace App\Services;

use App\Services\Interfaces\IDeviceService;
use App\Models\DeviceDetail;
use Illuminate\Support\Facades\Request;
use App\Repositories\Interfaces\IDeviceRepository;

class DeviceServices implements IDeviceService
{
	public $deviceRepo;

	public function __construct(IDeviceRepository $deviceRepo)
	{
		$this->deviceRepo = $deviceRepo;
	}
	// save the device details
	public function saveDeviceDetail($user_id)
	{
		$device_id =  Request::header('device-id') ?  Request::header('device-id') : "";
		// delete all the previous records in device details table
		$data = $this->deviceRepo->get_device(['user_id' => $user_id, 'device_id' => $device_id]);
		if ($data != null) {
			$data->delete();
		}
		// save device details
		$this->deviceRepo->create($this->getDeviceData($device_id, $user_id));
		return true;
	}

	// delete te device details
	public  function deleteDevice($user_id)
	{
		$device_id =  Request::header('device-id') ?  Request::header('device-id') : "";
		// delete all the previous records in device details table
		return $this->deviceRepo->delete_device_details(['user_id' => $user_id, 'device_id' => $device_id]);
	}

	private function getDeviceData($device_id, $user_id)
	{
		return [
			'device_id' => $device_id,
			'user_id' => $user_id,
			'device_token' => Request::header('FCM-token') ?? "",
			'build_version' => Request::header('build-version') ?? "",
			'platform' => Request::header('platform') ?? "",
			'build' => Request::header('build') ?? "",
			'build_mode' => Request::header('build-mode') ?? "",
		];
	}
}

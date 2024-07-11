<?php

namespace App\Services;

use App\Enum\CommonEnum;
use App\Exceptions\BadRequestException;
use App\Exceptions\RecordNotFoundException;
use App\Http\Requests\V1\Vehicle\AddVehicleRequest;
use App\Http\Requests\V1\Vehicle\DeleteVehicleRequest;
use App\Http\Requests\V1\Vehicle\GetVehicleModelRequest;
use App\Http\Requests\V1\Vehicle\UpdateVehicleRequest;
use App\Repositories\Interfaces\IUserVehicleRepository;
use App\Repositories\Interfaces\IVehicleRepository;
use App\Services\Interfaces\IVehicleServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleServices implements IVehicleServices
{
	private $vehicleRepository;
	private $userVehicleRepository;
	private $lang_path = 'Api/v1/vehicle.';
	public function __construct(IVehicleRepository $vehicleRepository, IUserVehicleRepository $userVehicleRepository)
	{
		$this->vehicleRepository = $vehicleRepository;
		$this->userVehicleRepository = $userVehicleRepository;
	}
	public function getVehicleCompany(Request $request)
	{
		$company_data =	$this->vehicleRepository->getCompany();
		if (!$company_data)
			throw new RecordNotFoundException(trans($this->lang_path . 'record_not_found'));
		$response = [];
		foreach ($company_data as $data) {
			$response[] = [
				'id' =>  $data->id,
				'company' =>  $data->make,
			];
		}
		return collect($response);
	}
	public function getModelDetails(GetVehicleModelRequest $request)
	{
		$item_per_page = $request->item_per_page ?? CommonEnum::PAGINATION_ITEM_PER_PAGE;
		$company_models =	$this->vehicleRepository->getCompanyModelDetails($request->company_id, $item_per_page);
		if (!$company_models->count() > 0)
			throw new RecordNotFoundException(trans($this->lang_path . 'record_not_found'));
		$response = [];
		foreach ($company_models as $data) {
			$response[] = [
				'id' =>  $data->id,
				'company_id' =>  $data->vehicle_company_id,
				'model' => $data->model,
				'engine' => $data->displ ? (float)$data->displ * 1000 : 0,
				'year' => $data->year
			];
		}
		return collect($response);
	}

	public function addVehicle(AddVehicleRequest $request)
	{
		$user = Auth::user();
		$this->validate_user_vehicle($user->id, $request);
		$user_vehicle =	$user->user_vehicles()->create($request->only('vehicle_id', 'purchased_year', 'insurance_company_name', 'insurance_policy_number', 'vin_number'));
		return $user_vehicle;
	}
	private function validate_user_vehicle($user_id, $request)
	{
		if ($this->userVehicleRepository->where(['user_id' => $user_id, 'vehicle_id' => $request->vehicle_id])->first())
			throw new BadRequestException(trans($this->lang_path . 'requested_vehicle_already_added'));
		if ($this->userVehicleRepository->where(['user_id' => $user_id, 'vin_number' => $request->vin_number])->first())
			throw new BadRequestException(trans($this->lang_path . 'vin_number_already_added'));
		if ($this->userVehicleRepository->where(['user_id' => $user_id, 'insurance_policy_number' => $request->insurance_policy_number])->first())
			throw new BadRequestException(trans($this->lang_path . 'insurance_policy_number_already_added'));
	}


	public function deleteVehicle(DeleteVehicleRequest $request)
	{
		$user = Auth::user();
		$user_vehicle = $user->user_vehicles()->find($request->user_vehicle_id);
		if (!$user_vehicle)
			return trans($this->lang_path . 'invalid_vehicle_selected');
		$user_vehicle->delete();
		return trans($this->lang_path . 'successfully_removed_vehicle');
	}
	public function getUserVehicles(Request $request)
	{
		$user = Auth::user();
		$item_per_page = $request->item_per_page ?? CommonEnum::PAGINATION_ITEM_PER_PAGE;
		$user_vehicle =	$user->user_vehicles()->latest()->paginate($item_per_page);
		if (!$user_vehicle->count() > 0)
			throw new RecordNotFoundException(trans($this->lang_path . 'record_not_found'));
		return $user_vehicle;
	}

	public function updateUserVehicle(UpdateVehicleRequest $request)
	{
		$user = Auth::user();
		$user_vehicle = $user->user_vehicles()->find($request->user_vehicle_id);
		if (!$user_vehicle)
			return trans($this->lang_path . 'invalid_vehicle_selected');
		if ($request->vin_number and $request->vin_number != "") {
			if ($this->userVehicleRepository->where(['user_id' => $user->id, 'vin_number' => $request->vin_number])->where('id', '!=', $request->user_vehicle_id)->first())
				throw new BadRequestException(trans($this->lang_path . 'vin_number_already_added'));
		}
		if ($request->insurance_policy_number and $request->insurance_policy_number != "") {
			if ($this->userVehicleRepository->where(['user_id' => $user->id, 'insurance_policy_number' => $request->insurance_policy_number])->where('id', '!=', $request->user_vehicle_id)->first())
				throw new BadRequestException(trans($this->lang_path . 'insurance_policy_number_already_added'));
		}
		$user_vehicle->update($this->getUpdateUserVehicleData($request));
		return $user_vehicle;
	}

	// get the update user update vehicle data
	private function getUpdateUserVehicleData($request)
	{
		$response = [];
		if ($request->purchased_year and $request->purchased_year != "")
			$response['purchased_year'] = $request->purchased_year;

		if ($request->insurance_company_name and $request->insurance_company_name != "")
			$response['insurance_company_name'] = $request->insurance_company_name;

		if ($request->insurance_policy_number and $request->insurance_policy_number != "")
			$response['insurance_policy_number'] = $request->insurance_policy_number;

		if ($request->vin_number and $request->vin_number != "")
			$response['vin_number'] = $request->vin_number;
		return $response;
	}
}

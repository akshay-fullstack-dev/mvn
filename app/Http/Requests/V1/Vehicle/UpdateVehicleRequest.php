<?php

namespace App\Http\Requests\V1\Vehicle;

use App\Traits\APIRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateVehicleRequest extends FormRequest
{
    use APIRequest;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_vehicle_id' => 'required|numeric|exists:user_vehicles,id',
            'purchased_year' => 'nullable|date_format:Y',
            'insurance_company_name' => 'nullable|string|min:5|max:100',
            'insurance_policy_number' => 'nullable|string|max:100|min:5',
            'vin_number' => 'nullable|string|max:50',
        ];
    }
}

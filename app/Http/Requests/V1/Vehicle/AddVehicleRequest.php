<?php

namespace App\Http\Requests\V1\Vehicle;

use App\Traits\APIRequest;
use Illuminate\Foundation\Http\FormRequest;

class AddVehicleRequest extends FormRequest
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
            'vehicle_id' => 'required|numeric|exists:vehicles,id',
            'purchased_year' => 'required|date_format:Y',
            'insurance_company_name' => 'nullable|string|max:100',
            'insurance_policy_number' => 'nullable|string|max:100',
            'vin_number' => 'required|string|max:50',
        ];
    }
}

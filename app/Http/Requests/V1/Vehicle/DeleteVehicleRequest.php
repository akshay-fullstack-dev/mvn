<?php

namespace App\Http\Requests\V1\Vehicle;

use App\Traits\APIRequest;
use Illuminate\Foundation\Http\FormRequest;

class DeleteVehicleRequest extends FormRequest
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
            'user_vehicle_id' => 'required|numeric|exists:user_vehicles,id'
        ];
    }
}

<?php

namespace App\Http\Requests\V1\Auth;

use App\Enum\OtpEnum;
use Illuminate\Validation\Rule;
use App\Traits\APIRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateVendorLocationRequest extends FormRequest
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
            "latitude" => 'required|numeric',
            "longitude" => 'required|numeric'
        ];
    }
}

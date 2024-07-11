<?php

namespace App\Http\Requests\V1\ClientRequests\Auth;

use App\Traits\APIRequest;
use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
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
            'phone_number' => 'required|numeric|digits_between:7,25',
            'country_code' => 'required|string|max:10',
            'password' => 'required|string'
        ];
    }
}

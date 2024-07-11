<?php

namespace App\Http\Requests\V1\Auth;

use App\Traits\APIRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use stdClass;

class CreateUserRequest extends FormRequest
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
            // required  parameters
            'email' => 'required|email|max:100',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'phone_number' => 'required|numeric|digits_between:5,20',
            'country_iso_code' => 'required|string|max:10', //IN
            'country_code' => 'required|string|max:20', //+91
        ];
    }
}

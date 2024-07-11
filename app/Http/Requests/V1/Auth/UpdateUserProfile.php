<?php

namespace App\Http\Requests\V1\Auth;

use App\Traits\APIRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use stdClass;

class UpdateUserProfile extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|email',
            'name' => 'required|string',
            'bio' => 'required|string',
            'phone_number' => 'required|string',
            'profile_picture' => 'string',
            'bio' => 'string',
            "address.country"=>'required|string',
            "address.city"=>'required|string',
            "address.province"=>'required|string',
            "address.formatted_address"=>'required|string',
            "address.additional_info"=>'required|string',
            "address.latitude"=>'required|numeric',
            "address.longitude"=>'required|numeric',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = new JsonResponse([
            'status' => 0,
            'message' => $validator->errors()->first(),
            'data' => new stdClass,
        ], 200);

        throw new ValidationException($validator, $response);
    }
}

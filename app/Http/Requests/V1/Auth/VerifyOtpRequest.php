<?php

namespace App\Http\Requests\V1\Auth;

use App\Enum\OtpEnum;
use Illuminate\Validation\Rule;
use App\Traits\APIRequest;
use Illuminate\Foundation\Http\FormRequest;

class VerifyOtpRequest extends FormRequest
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
            "verify_type" => [
                'required',
                Rule::in([OtpEnum::login_response, OtpEnum::verify_otp]),
            ],
            'otp_code' => 'required|numeric|digits:6',
            "phone_number" => 'required|numeric|digits_between:5,20',
            "country_code" => "required|string|max:5"
        ];
    }
}

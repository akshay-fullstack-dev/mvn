<?php

namespace App\Http\Requests\V1\Auth;

use App\Enum\OtpEnum;
use App\Traits\APIRequest;
use Illuminate\Foundation\Http\FormRequest;

class SendOtpRequest extends FormRequest
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
            'action' => 'required|integer|in:' . OtpEnum::sendEmail . ',' . OtpEnum::sendPhoneNumber,
            // phone number verification
            'country_code' => 'nullable|required_if:action,' . OtpEnum::sendPhoneNumber . '|string|max:5',
            'phone_number' => 'nullable|required_if:action,' . OtpEnum::sendPhoneNumber . '|numeric|digits_between:5,20',

            // email number verification
            'email' => 'nullable|required_if:action,' . OtpEnum::sendEmail . '|email|max:50'
        ];
    }
}

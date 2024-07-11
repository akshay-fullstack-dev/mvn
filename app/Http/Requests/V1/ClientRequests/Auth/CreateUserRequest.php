<?php

namespace App\Http\Requests\V1\ClientRequests\Auth;

use App\Enum\UserEnum;
use App\Traits\APIRequest;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

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
            'email' => 'required|email',
            'first_name' => 'required|string|max:50',
            'last_name' => 'nullable|string|max:50',
            'password' => 'required|string|max:50',
            'profile_image' => 'nullable|string',
            "country_code" => 'required|max:10',
            'phone_number' => 'required|numeric|digits_between:7,20',
            "country_iso_code" => 'required|max:10',
            'referral_code' => 'nullable|string|max:15|min:5|exists:users,referral_code'
        ];
    }
}

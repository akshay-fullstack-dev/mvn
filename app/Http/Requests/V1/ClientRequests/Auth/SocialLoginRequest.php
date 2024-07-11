<?php

namespace App\Http\Requests\V1\ClientRequests\Auth;

use App\Enum\UserEnum;
use App\Traits\APIRequest;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SocialLoginRequest extends FormRequest
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
            'login_type' => [
                'required',
                'integer',
                Rule::in([UserEnum::GMAIL_LOGIN, UserEnum::FACEBOOK_LOGIN, UserEnum::APPLE_LOGIN]),
            ],
            'social_id' => 'required|string',
            // optional parameters
            'email' => 'sometimes|nullable|email',
            'first_name' =>'sometimes|nullable|string|max:50',
            'last_name' => 'sometimes|nullable|string|max:50',
            'phone_number' => 'sometimes|nullable|string',
            'profile_image' => 'sometimes|nullable|string'
        ];
    }
}

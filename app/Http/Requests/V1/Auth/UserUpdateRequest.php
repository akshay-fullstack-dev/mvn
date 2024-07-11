<?php

namespace App\Http\Requests\V1\Auth;

use App\Traits\APIRequest;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    use APIRequest;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $response_data['address'] = json_decode('[{
            "city": "Chandigarh",
            "country": "India",
            "type":1,
            "formatted_address": "Sector 46, Chandigarh, 160047, India",
            "latitude": 30.701567,
            "longitude": 76.765273
        }]');
        return [
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|string|email|max:100',
            'phone_number' => 'required|numeric|digits_between:5,20',
            'country_iso_code' => 'required|string|max:10',
            'country_code' => 'required|string|max:20',
            'address' => [
                'city' => 'required|string|max:50',
                'country' => 'required|string|max:50',
                'type'=>'required|'
            ]
        ];
    }
}

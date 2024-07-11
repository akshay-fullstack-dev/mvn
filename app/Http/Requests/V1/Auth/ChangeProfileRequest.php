<?php

namespace App\Http\Requests\V1\Auth;

use Illuminate\Validation\Rule;
use App\Traits\APIRequest;
use Illuminate\Foundation\Http\FormRequest;

class ChangeProfileRequest extends FormRequest
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
            'vendor_type' => 'nullable|numeric|in:0,1',
            'first_name' => 'nullable|string|max:50',
            'last_name' => 'nullable|string|max:50',
            // address validation
            'address' => 'nullable|array',
            'address.*.address_id' => 'nullable|numeric|exists:user_addresses,id',
            'address.*.house_no' => 'nullable|string|max:25',
            'address.*.state' => 'nullable|string|max:100',
            'address.*.zip_code' => 'nullable|string|max:50',
            'address.*.city' => 'nullable|string|max:50',
            'address.*.country' => 'nullable|string|max:50',
            'address.*.type' => 'required|integer|max:50',
            'address.*.additional_info' => 'required|string|max:500',
            'address.*.latitude' => 'required|numeric|max:1000',
            'address.*.longitude' => 'required|numeric|max:1000',
        ];
    }
    public function messages()
    {
        return [
            'address.*.id.exists' => trans('Api/v1/auth.invalid_address_id_provided',),
            'address.*.city.max' => trans('Api/v1/auth.value_not_greater_than_limit', ['name' => 'City', 'value' => 50]),
            'address.*.city.string' => trans('Api/v1/auth.must_be_a_string', ['name' => 'City']),

            'address.*.country.max' => trans('Api/v1/auth.value_not_greater_than_limit', ['name' => 'Country', 'value' => 50]),
            'address.*.country.string' => trans('Api/v1/auth.must_be_a_string', ['name' => 'Country']),

            'address.*.type.max' => trans('Api/v1/auth.value_not_greater_than_limit', ['name' => 'Address type', 'value' => 50]),
            'address.*.type.integer' => trans('Api/v1/auth.value_must_be_an_integer', ['name' => 'Address type']),
            'address.*.type.required' => trans('Api/v1/auth.is_required', ['name' => 'Address type']),

            'address.*.additional_info.required' => trans('Api/v1/auth.is_required', ['name' => 'additional info']),
            'address.*.additional_info.string' => trans('Api/v1/auth.must_be_a_string', ['name' => 'additional info']),
            'address.*.additional_info.max' => trans('Api/v1/auth.value_not_greater_than_limit', ['name' => 'additional info', 'value' => 500]),

            'address.*.latitude.required' => trans('Api/v1/auth.is_required', ['name' => 'latitude']),
            'address.*.latitude.numeric' => trans('Api/v1/auth.must_be_a_numeric', ['name' => 'latitude']),
            'address.*.latitude.max' => trans('Api/v1/auth.is_digits_between', ['name' => 'latitude', 'A' => 0, 'B' => 1000]),

            'address.*.longitude.required' => trans('Api/v1/auth.is_required', ['name' => 'longitude']),
            'address.*.longitude.numeric' => trans('Api/v1/auth.must_be_a_numeric', ['name' => 'longitude']),
            'address.*.longitude.max' => trans('Api/v1/auth.is_digits_between', ['name' => 'latitude', 'A' => 0, 'B' => 1000]),

            'address.*.house_no.max' => trans('Api/v1/auth.value_not_greater_than_limit', ['name' => 'House number', 'value' => 25]),
            'address.*.house_no.string' => trans('Api/v1/auth.must_be_a_string', ['name' => 'House number']),

            'address.*.state.max' => trans('Api/v1/auth.value_not_greater_than_limit', ['name' => 'State', 'value' => 100]),
            'address.*.state.string' => trans('Api/v1/auth.must_be_a_string', ['name' => 'State']),

            'address.*.zip_code.max' => trans('Api/v1/auth.value_not_greater_than_limit', ['name' => 'Zip code', 'value' => 100]),
            'address.*.zip_code.string' => trans('Api/v1/auth.must_be_a_string', ['name' => 'Zip code']),

        ];
    }
}

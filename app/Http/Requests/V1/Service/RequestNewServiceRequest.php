<?php

namespace App\Http\Requests\V1\Service;

use App\Traits\APIRequest;
use Illuminate\Foundation\Http\FormRequest;

class RequestNewServiceRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'service_name' => 'required|string|max:400',
            'service_description' => 'nullable|string|max:1500',
            'service_price' => 'nullable|numeric',
            'service_time' => 'nullable|date_format:H:i',
            'whats_included' => 'nullable|array',
            'whats_included.*' => 'string',
            // images validation 
            'service_images' => 'nullable|array',
            'service_images.*' => 'string',
            'category_id' => 'required|exists:service_category,id',
            'spare_parts' => "nullable|string"
        ];
    }

    public function messages()
    {
        return [
            'whats_included.*.string' => trans('Api/v1/service.value_must_be_string', ['name' => 'Whats included']),

            'service_images.*.string' => trans('Api/v1/service.value_must_be_string', ['name' => 'Service images']),
        ];
    }
}

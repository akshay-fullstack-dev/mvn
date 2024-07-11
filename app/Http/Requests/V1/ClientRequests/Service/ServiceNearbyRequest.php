<?php

namespace App\Http\Requests\V1\ClientRequests\Service;

use App\Enum\UserEnum;
use App\Traits\APIRequest;
// use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServiceNearbyRequest extends FormRequest
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
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
            'vendor_type' => [
                'required',
                'numeric',
                Rule::in([UserEnum::SHOP_CERTIFIED_VENDOR, UserEnum::NORMAL_VENDOR])
            ],
            'item_per_page' => 'nullable|numeric|max:500',
            'category_id' => 'nullable|exists:service_category,id'
        ];
    }
}

<?php

namespace App\Http\Requests\V1\Service;

use App\Traits\APIRequest;
use Illuminate\Foundation\Http\FormRequest;

class GetServiceRequest extends FormRequest
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
            'enrolled' => 'required|numeric|in:0,1',
            'page' => 'nullable|numeric',
            'item_per_page' => 'nullable|numeric',
            'category_id' => 'nullable|numeric|exists:service_category,id'
        ];
    }
}

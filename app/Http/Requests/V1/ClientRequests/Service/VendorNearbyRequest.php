<?php

namespace App\Http\Requests\V1\ClientRequests\Service;

use App\Traits\APIRequest;
use Illuminate\Foundation\Http\FormRequest;

class VendorNearbyRequest extends FormRequest
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
            'service_id' => 'required|numeric|exists:services,id',
            'item_per_page' => 'nullable|numeric|max:500'
        ];
    }
}

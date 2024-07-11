<?php

namespace App\Http\Requests\V1\ClientRequests\Service;

use App\Traits\APIRequest;
use Illuminate\Foundation\Http\FormRequest;

class VendorServiceDetailsRequest extends FormRequest
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
            'lat' => 'nullable|numeric',
            'long' => 'nullable|numeric',
            'service_id' => 'required|numeric|exists:services,id',
            'vendor_id' => 'required|numeric|exists:users,id',
        ];
    }
}

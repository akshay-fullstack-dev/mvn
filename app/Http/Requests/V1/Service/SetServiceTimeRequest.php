<?php

namespace App\Http\Requests\V1\Service;

use App\Traits\APIRequest;
use Illuminate\Foundation\Http\FormRequest;

class SetServiceTimeRequest extends FormRequest
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
            'service_id' => 'required|numeric|exists:services,id',
            'time' => 'required|date_format:H:i'
        ];
    }
}

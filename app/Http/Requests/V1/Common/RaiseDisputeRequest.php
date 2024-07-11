<?php

namespace App\Http\Requests\V1\Common;

use App\Traits\APIRequest;
use Illuminate\Foundation\Http\FormRequest;

class RaiseDisputeRequest extends FormRequest
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
            'booking_id' => 'required|integer|exists:bookings,id',
            'message' => 'required|string|min:20|max:2500'
        ];
    }
}

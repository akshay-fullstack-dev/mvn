<?php

namespace App\Http\Requests\V1\Notification;

use Illuminate\Foundation\Http\FormRequest;

class GetNotificationRequest extends FormRequest
{
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
            'item_per_page' => 'nullable|numeric',
            'page' => 'nullable|numeric'
        ];
    }
}

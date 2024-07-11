<?php

namespace IntersoftChat\App\Http\Requests;

use App\Traits\APIRequest;
use Illuminate\Foundation\Http\FormRequest;

class MessageListingRequest extends FormRequest
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
            'sender_id' => 'required|numeric|exists:users,id',
            'receiver_id' => 'required|numeric|exists:users,id',
            'page' => 'nullable|numeric',
            'item_per_page' => 'nullable|numeric'
        ];
    }
}

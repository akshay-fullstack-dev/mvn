<?php

namespace IntersoftChat\App\Http\Requests;

use IntersoftChat\App\Enums\ChatEnum;
use App\Traits\APIRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SendMessageRequest extends FormRequest
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
            'receiver_id' => 'required|numeric|exists:App\User,id',
            'message_type' => [
                'required',
                'integer',
                Rule::in([ChatEnum::type_message, ChatEnum::type_image]),
            ],
            'message' => "required|string|max:2500",
            'message_time' => 'required|date_format:Y-m-d H:i:s'
        ];
    }
}

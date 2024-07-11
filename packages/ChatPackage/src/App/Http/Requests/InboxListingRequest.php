<?php

namespace IntersoftChat\App\Http\Requests;

use App\Traits\APIRequest;
use Illuminate\Foundation\Http\FormRequest;

class InboxListingRequest extends FormRequest
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
            'page' => "nullable|numeric",
            'item_per_page' => 'nullable|numeric'
        ];
    }
}

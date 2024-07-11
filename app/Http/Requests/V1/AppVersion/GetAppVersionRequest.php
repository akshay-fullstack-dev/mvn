<?php

namespace App\Http\Requests\V1\AppVersion;

use App\Traits\APIRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetAppVersionRequest extends FormRequest
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
            'bundle_id' => 'required|exists:app_packages,bundle_id',
            'platform' => ['required', Rule::in([0, 1])]
        ];
    }
}

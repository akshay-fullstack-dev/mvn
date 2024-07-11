<?php

namespace App\Http\Requests\Admin\AppVersion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreAppVersion extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // return Gate::allows('admin.app-version.create');
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'force_update' => ['required', 'boolean'],
            'message' => ['required', 'string'],
            'version' => ['required', 'numeric'],
            'code' => ['required', 'string'],
            'platform' => ['required', 'boolean'],
            'app_packages' => ['required', 'array', 'min:1']

        ];
    }

    /**
     * Modify input data
     *
     * @return array
     */
    public function getSanitized($request): array
    {
        $sanitized = $this->validated();
        $sanitized['app_package_id'] = $request->app_packages['id'];
        //Add your code for manipulation with request data here

        return $sanitized;
    }
}

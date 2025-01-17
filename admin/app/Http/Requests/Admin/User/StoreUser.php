<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.user.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['nullable', 'string'],
            'email' => ['required', 'email', 'string'],
            'email_verified_at' => ['nullable', 'date'],
            'phone_number' => ['required', 'string'],
            'country_iso_code' => ['required', 'string'],
            'is_blocked' => ['required', 'boolean'],
            'account_status' => ['required', 'boolean'],
            'country_code' => ['required', 'string'],
            'document.*' => ['required'],
            'city.*' => ['required', 'string'],
            'country.*' => ['required', 'string'],


            
        ];
    }

    /**
    * Modify input data
    *
    * @return array
    */
    public function getSanitized(): array
    {
        $sanitized = $this->validated();

        //Add your code for manipulation with request data here

        return $sanitized;
    }
}

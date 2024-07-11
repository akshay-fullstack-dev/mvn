<?php

namespace App\Http\Requests\Admin\UserDocument;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateUserDocument extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.user-document.edit', $this->userDocument);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'user_id' => ['sometimes', 'string'],
            'document_name' => ['sometimes', 'string'],
            'document_number' => ['nullable', 'string'],
            'front_image' => ['sometimes', 'string'],
            'back_image' => ['nullable', 'string'],
            'document_type' => ['sometimes', 'boolean'],
            'document_status' => ['sometimes', 'boolean'],
            'message' => ['nullable', 'string'],
            
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

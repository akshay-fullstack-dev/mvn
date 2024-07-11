<?php

namespace App\Http\Requests\V1\Auth;

use App\Enum\DocumentEnum;
use App\Traits\APIRequest;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;


class UploadUserDocumentRequest extends FormRequest
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
            "documents" => 'required|array',
            "documents.*.document_name" => 'required|string|max:255',
            "documents.*.document_number" => 'nullable|string|max:255',
            "documents.*.front_image" => "required|string|max:1000",
            "documents.*.back_image" => "nullable|string|max:1000",
            "documents.*.document_type" => [
                'required',
                Rule::in([DocumentEnum::DRIVING_LICENCE, DocumentEnum::HIGH_SCHOOL_DIPLOMA, DocumentEnum::OTHER_DOCUMENT_TYPE]),
            ]

        ];
    }

    public function messages()
    {
        return [
            "*.document_name.required" => trans('Api/v1/auth.document_name_required'),
            "*.front_image.required" => trans('Api/v1/auth.front_image_required'),
            "*.document_type.required" => trans('Api/v1/auth.document_type_required'),
            // in rules
            "*.document_type.in" => trans('Api/v1/auth.invalid_document_type'),
            // add the limit validations
            "*.document_name.max" => trans('Api/v1/auth.value_not_greater_than_limit', ['name' => 'Document name', 'value' => 255]),
            "*.document_number.max" => trans('Api/v1/auth.value_not_greater_than_limit', ['name' => 'Document number', 'value' => 255]),
            "*.front_image.max" => trans('Api/v1/auth.value_not_greater_than_limit', ['name' => 'Front image', 'value' => 1000]),
            "*.back_image.max" => trans('Api/v1/auth.value_not_greater_than_limit', ['name' => 'Back image', 'value' => 1000]),

        ];
    }
}

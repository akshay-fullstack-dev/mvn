<?php

namespace App\Http\Requests\Admin\PackageMaintain;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdatePackageMaintain extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.package-maintain.edit', $this->packageMaintain);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'package_id' => ['sometimes', 'integer'],
            'user_id' => ['sometimes', 'integer'],
            'order_id' => ['sometimes', 'string'],
            'transaction_id' => ['sometimes', 'string'],
            'amount' => ['sometimes', 'string'],
            
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

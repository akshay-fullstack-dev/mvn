<?php

namespace App\Http\Requests\Admin\Package;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdatePackage extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // return Gate::allows('admin.package.edit', $this->package);
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
            'name' => ['sometimes', 'string'],
            'description' => ['nullable', 'string'],
            'status' => ['sometimes', 'boolean'],
            'booking_gap' => ['sometimes', 'integer'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'no_of_times' => ['required', 'numeric'],
            'normal_price' => ['required', 'numeric'],
            'dealer_price' => ['required', 'numeric'],
            'sparepartdescription'=>['nullable','string']
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

<?php

namespace App\Http\Requests\Admin\Package;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StorePackage extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // return Gate::allows('admin.package.create');
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
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'status' => ['sometimes', 'boolean'],
            'booking_gap' => ['required', 'integer', 'min:1', 'max:30'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'no_of_times' => ['required', 'numeric', 'min:1'],
            'normal_price' => ['required', 'numeric'],
            'dealer_price' => ['required', 'numeric', 'gt:normal_price'],
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

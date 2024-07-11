<?php

namespace App\Http\Requests\Admin\Service;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateService extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // return Gate::allows('admin.service.edit', $this->service);
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
            'name' => ['required'],
            'description' => ['sometimes', 'string'],
            'price' => ['sometimes', 'string'],
            'approx_time' => ['sometimes', 'date_format:H:i:s'],
            'whatsincluded.*' => ['required'],
            'serviceCategory' => 'required|array|min:1',
            'serviceCategory.id' => 'required|exists:service_category,id',
            'spare_parts' => 'nullable|string',
            'spare_part_price' => 'nullable|numeric',
            'dealer_price' => 'nullable|numeric'
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
        $sanitized['service_category_id']  = $this->serviceCategory['id'];
        unset($sanitized['serviceCategory']);
        //Add your code for manipulation with request data here

        return $sanitized;
    }
}

<?php

namespace App\Http\Requests\Admin\Coupon;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateCoupon extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.coupon.edit', $this->coupon);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'coupon_code' => ['sometimes', 'string'],
            'coupon_discount' => ['sometimes', 'numeric'],
            'coupon_max_amount' => ['nullable', 'numeric'],
            'coupon_min_amount' => ['nullable', 'numeric'],
            'coupon_name' => ['sometimes', 'string'],
            'coupon_type' => ['sometimes', 'boolean'],
            'end_date' => ['sometimes', 'date'],
            'maximum_per_customer_use' => ['nullable', 'integer'],
            'maximum_total_use' => ['nullable', 'integer'],
            'start_date' => ['sometimes', 'date'],
            'users_id' => ['nullable', 'string'],
            'coupon_description' => ['required', 'string'],

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

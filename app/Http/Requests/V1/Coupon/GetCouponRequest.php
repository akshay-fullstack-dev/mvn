<?php

namespace App\Http\Requests\V1\Coupon;

use Illuminate\Foundation\Http\FormRequest;

class GetCouponRequest extends FormRequest
{
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
            'item_per_page' => 'nullable|integer'
        ];
    }
}

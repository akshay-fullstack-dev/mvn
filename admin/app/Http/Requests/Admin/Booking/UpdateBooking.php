<?php

namespace App\Http\Requests\Admin\Booking;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateBooking extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.booking.edit', $this->booking);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'order_id' => ['sometimes', 'string'],
            'user_id' => ['sometimes', 'string'],
            'vendor_id' => ['nullable', 'string'],
            'service_id' => ['sometimes', 'string'],
            'address_id' => ['sometimes', 'string'],
            'payment_id' => ['sometimes', 'string'],
            'package_id' => ['nullable', 'string'],
            'vehicle_id' => ['sometimes', 'string'],
            'booking_start_time' => ['nullable', 'date'],
            'booking_end_time' => ['nullable', 'date'],
            'booking_status' => ['sometimes', 'boolean'],
            'booking_type' => ['sometimes', 'boolean'],
            'addition_info' => ['nullable', 'string'],
            
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

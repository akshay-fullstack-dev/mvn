<?php

namespace App\Http\Requests\Admin\Booking;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreBooking extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.booking.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'order_id' => ['required', 'string'],
            'user_id' => ['required', 'string'],
            'vendor_id' => ['nullable', 'string'],
            'service_id' => ['required', 'string'],
            'address_id' => ['required', 'string'],
            'payment_id' => ['required', 'string'],
            'package_id' => ['nullable', 'string'],
            'vehicle_id' => ['required', 'string'],
            'booking_start_time' => ['nullable', 'date'],
            'booking_end_time' => ['nullable', 'date'],
            'booking_status' => ['required', 'boolean'],
            'booking_type' => ['required', 'boolean'],
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

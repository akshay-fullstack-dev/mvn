<?php

namespace App\Http\Requests\V1\Booking;

use App\Enum\BookingEnum;
use App\Traits\APIRequest;
use App\Traits\LangTrait;
// use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookingDetailsRequest extends FormRequest
{
    use APIRequest;
    use LangTrait;
    private $lang = 'validation';
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
            'booking_type' => [
                'nullable', 'numeric',
                Rule::in([BookingEnum::NormalBooking, BookingEnum::PackageBooking]),
            ],

            'order_id' => 'required_if:booking_type,' . BookingEnum::PackageBooking . '|string|exists:bookings,order_id',
            'booking_id' => 'required_if:booking_type,' . BookingEnum::NormalBooking . '|integer|exists:bookings,id'
        ];
    }
}

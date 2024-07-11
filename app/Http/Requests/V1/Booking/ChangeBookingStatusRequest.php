<?php

namespace App\Http\Requests\V1\Booking;

use App\Enum\BookingEnum;
use App\Traits\APIRequest;
use App\Traits\LangTrait;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChangeBookingStatusRequest extends FormRequest
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
            'booking_id' => 'required|integer|exists:bookings,id',
            'booking_status' => ['required', 'integer', Rule::in(
                BookingEnum::VendorOutForService,
                BookingEnum::VendorStartedJob,
                BookingEnum::VendorJobFinished,
                BookingEnum::bookingCancelled,
                BookingEnum::VendorReachedLocation,
            )],
            'cancel_reason' => ['nullable', 'string', 'max:3500']
        ];
    }
}

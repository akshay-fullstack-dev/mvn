<?php

namespace App\Http\Requests\V1\Booking;

use App\Enum\BookingEnum;
use App\Traits\APIRequest;
use App\Traits\LangTrait;
// use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VendorBookingDetailsRequest extends FormRequest
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
            'booking_status' => [
                'required', 'numeric',
                Rule::in(
                    [
                        BookingEnum::UpcomingVendorBookingRequest,
                        BookingEnum::BookingVendorOngoingJobRequest,
                        BookingEnum::BookingCompletedOrCancelledRequest,
                        BookingEnum::VendorBookingRequests
                    ]
                ),
            ],
            'booking_date' => 'nullable|string|date_format:Y-m-d',
        ];
    }
}

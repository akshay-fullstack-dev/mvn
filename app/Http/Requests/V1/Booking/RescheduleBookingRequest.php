<?php

namespace App\Http\Requests\V1\Booking;
use App\Traits\APIRequest;
use App\Traits\LangTrait;
// use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RescheduleBookingRequest extends FormRequest
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
            'booking_id' => 'required|numeric|exists:bookings,id',
            'selected_date' => 'required|string|date_format:Y-m-d',
            'selected_time' => 'required|string|date_format:H:i',
        ];
    }
}

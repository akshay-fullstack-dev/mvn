<?php

namespace App\Http\Requests\V1\Booking;

use App\Traits\APIRequest;
use App\Traits\LangTrait;
use Illuminate\Foundation\Http\FormRequest;

class BookServiceRequest extends FormRequest
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
            'booking_type' => 'required|numeric',
            'vendor_id' => 'nullable|numeric|exists:users,id',
            'address_id' => 'required|numeric|exists:user_addresses,id',
            'service_id' => 'required|numeric|exists:services,id',
            // !i have to added the exist validation to the package id
            'package_id' => 'nullable|numeric',
            // added payment details
            'payment_details' => 'required|array|min:1',
            'payment_details.card_id' => 'required|string|max:50',
            'payment_details.total_amount' => 'required|numeric',
            'payment_details.currency_code' => 'required|string',
            'payment_details.total_amount_paid' => 'required|numeric',
            'payment_details.delivery_charges' => 'required|numeric',
            'payment_details.booking_distance' => 'required|numeric',
            'payment_details.basic_service_charge' => 'required|numeric',
            'payment_details.via_wallet' => 'required|numeric|max:25',
            'payment_details.spare_part_price' => 'sometimes|numeric',


            // ------------coupons validation lies here----------
            'payment_details.coupon_details' => 'nullable|array|min:2',
            'payment_details.coupon_details.coupon_id' => 'nullable|numeric|exists:coupons,id',
            'payment_details.coupon_details.discount_amount' => 'nullable|numeric',

            // booking details
            'booking_details' => 'required|array|min:1',
            'booking_details.*.vehicle_id' => 'required|numeric|exists:vehicles,id',
            'booking_details.*.date' => 'required|date_format:Y-m-d',
            'booking_details.*.time' => 'required|date_format:H:i',
            'booking_details.*.additional_info' => 'nullable|string|min:5|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'payment_details.card_id.required' => $this->getMessage('required', ['attribute' => 'payment card id']),
            'payment_details.card_id.string' => $this->getMessage('string', ['attribute' => 'card id']),
            'payment_details.card_id.max' => $this->getMessage('max.numeric', ['attribute' => 'card id', 'max' => 50]),

            'payment_details.spare_part_price.numeric' => $this->getMessage('numeric', ['attribute' => 'spare part price']),

            'payment_details.total_amount.required' => $this->getMessage('required', ['attribute' => 'payment total amount']),
            'payment_details.total_amount.numeric' => $this->getMessage('numeric', ['attribute' => 'payment total amount']),

            'payment_details.total_amount_paid.required' => $this->getMessage('required', ['attribute' => 'payment total amount paid']),
            'payment_details.total_amount_paid.numeric' => $this->getMessage('numeric', ['attribute' => 'payment total amount paid']),

            'payment_details.delivery_charges.required' => $this->getMessage('required', ['attribute' => 'payment delivery charges']),
            'payment_details.delivery_charges.numeric' => $this->getMessage('numeric', ['attribute' => 'payment delivery charges']),

            'payment_details.booking_distance.required' => $this->getMessage('required', ['attribute' => 'payment booking distance']),
            'payment_details.booking_distance.numeric' => $this->getMessage('numeric', ['attribute' => 'payment booking distance']),

            'payment_details.currency_code.required' => $this->getMessage('required', ['attribute' => 'payment currency code']),
            'payment_details.currency_code.string' => $this->getMessage('required', ['attribute' => 'payment currency code']),

            'payment_details.basic_service_charge.required' => $this->getMessage('required', ['attribute' => 'payment basic service charges']),
            'payment_details.basic_service_charge.numeric' => $this->getMessage('numeric', ['attribute' => 'payment basic service charges']),

            'payment_details.via_wallet.required' => $this->getMessage('required', ['attribute' => 'payment basic service charges']),
            'payment_details.via_wallet.numeric' => $this->getMessage('numeric', ['attribute' => 'payment basic service charges']),

            // coupons messages
            'payment_details.coupon_details.array' => $this->getMessage('array', ['attribute' => 'payment coupon details']),
            'payment_details.coupon_details.coupon_id.required' => $this->getMessage('required', ['attribute' => 'payment coupon id']),

            'payment_details.coupon_details.coupon_id.numeric' => $this->getMessage('numeric', ['attribute' => 'payment coupon id']),
            'payment_details.coupon_details.coupon_id.exists' => $this->getMessage('exists', ['attribute' => 'payment coupon id']),

            'payment_details.coupon_details.discount_amount.numeric' => $this->getMessage('numeric', ['attribute' => 'payment coupon discount']),
            'payment_details.coupon_details.discount_amount.exists' => $this->getMessage('attribute', ['attribute' => 'payment coupon discount']),

            // booking_details messages
            'booking_details.*.vehicle_id.required' => $this->getMessage('required', ['attribute' => 'booking vehicle id']),
            'booking_details.*.vehicle_id.exists' => $this->getMessage('exists', ['attribute' => 'booking vehicle id']),

            'booking_details.*.date.required' => $this->getMessage('required', ['attribute' => 'booking date']),
            'booking_details.*.date.date_format' => $this->getMessage('date_format', ['attribute' => 'booking date', 'format' => 'Y-m-d']),

            'booking_details.*.time.required' => $this->getMessage('required', ['attribute' => 'booking time']),
            'booking_details.*.time.date_format' => $this->getMessage('required', ['attribute' => 'booking time', 'format' => 'H:i']),

            'booking_details.*.additional_info.string' => $this->getMessage('string', ['attribute' => 'booking additional info']),
            'booking_details.*.additional_info.min' => $this->getMessage('min', ['attribute' => 'booking additional info', 'min' => 5]),
            'booking_details.*.additional_info.max' => $this->getMessage('max', ['attribute' => 'booking additional info', 'max' => 1000]),
        ];
    }
}

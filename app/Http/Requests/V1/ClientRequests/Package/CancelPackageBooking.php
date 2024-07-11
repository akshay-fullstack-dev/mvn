<?php

namespace App\Http\Requests\V1\ClientRequests\Package;

use App\Traits\APIRequest;
use App\Traits\LangTrait;

use Illuminate\Foundation\Http\FormRequest;

class CancelPackageBooking extends FormRequest
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
            'order_id' => 'required|string|exists:bookings,order_id'
        ];
    }
}

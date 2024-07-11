<?php

namespace App\Http\Resources\v1\Auth;

use App\Http\Resources\v1\Service\Service;
use Illuminate\Http\Resources\Json\JsonResource;
use stdClass;

class UserResource extends JsonResource
{
    public function __construct($resource)
    {
        parent::__construct($resource);
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $response_data = [
            'user_id' => $this->id,
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name ?? "",
            'is_blocked' => $this->is_blocked,
            'profile_status' => $this->account_status,
            'phone_number' => $this->phone_number ?? "",
            'country_iso_code' => $this->country_iso_code ?? "",
            'country_code' => $this->country_code ?? "",
            'offline' => $this->is_offline,
            'wallet_amount' => $this->wallet_money ?? 0.00,
            'referral_code' => $this->referral_code,
            'login_type' => $this->login_type,
            'profile_picture' => $this->profile_picture ?? "",
            'reason' => $this->rejection_reasons->count() > 0  ? $this->rejection_reasons[0]['reason'] : "",
            'user_documents' => $this->user_documents ? UserDocumentsResource::collection($this->user_documents) : [],
            'address' => $this->user_verified_address ? UserAddressResource::collection($this->user_verified_address) : []
        ];

        if (isset($this->services) && $this->services)
            $response_data['vendor_services'] = new Service($this->services);

        if (isset($this->access_token)) {
            $response_data['access_token'] = $this->access_token;
        }
        if (isset($this->delivery_charges)) {
            $response_data['delivery_charges'] = round($this->delivery_charges, 2);
        }
        //this parameter is used in vendor response to send the vendor
        if (isset($this->distance_between_user_and_vendor_in_km)) {
            $response_data['distance'] = round($this->distance_between_user_and_vendor_in_km, 2);
        }
        if (isset($this->delivery_price_per_km)) {
            $response_data['delivery_price_per_km'] = $this->delivery_price_per_km;
        }

        return $response_data;
    }
}

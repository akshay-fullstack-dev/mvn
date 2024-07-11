<?php

namespace App\Models;

use App\Helpers\CurrencyHelper;
use Illuminate\Database\Eloquent\Model;

class BookingPayment extends Model
{
    protected $guarded = [];
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'payment_id');
    }
    public function getTotalAmountAttribute($value)
    {
        return CurrencyHelper::format_currency_us_local($value, $this->currency_code);
    }
    public function getTotalAmountPaidAttribute($value)
    {
        return CurrencyHelper::format_currency_us_local($value, $this->currency_code);
    }
    public function getDeliveryChargesAttribute($value)
    {
        return CurrencyHelper::format_currency_us_local($value, $this->currency_code);
    }
    public function getBasicServiceChargeAttribute($value)
    {
        return CurrencyHelper::format_currency_us_local($value, $this->currency_code);
    }
    public function getViaWalletAttribute($value)
    {
        return CurrencyHelper::format_currency_us_local($value, $this->currency_code);
    }
    public function getDiscountAmountAttribute($value)
    {
        return CurrencyHelper::format_currency_us_local($value, $this->currency_code);
    }
    public function getServiceChargeReceivedByAdminAttribute()
    {
        $value = ((float)$this->basic_service_charge_received_by_admin + (float)$this->delivery_charge_received_by_admin);
        return CurrencyHelper::format_currency_us_local($value, $this->currency_code);
    }
    public function getServiceChargeReceivedByVendorAttribute()
    {
        $value = ((float)$this->basic_service_charge_received_by_vendor + (float)$this->delivery_charge_received_by_vendor);

        return CurrencyHelper::format_currency_us_local($value, $this->currency_code);
    }
    // public function getDeliveryChargeReceivedByAdminAttribute($value)
    // {
    //     return CurrencyHelper::format_currency_us_local($value, $this->currency_code);
    // }
    // public function getDeliveryChargeReceivedByVendorAttribute($value)
    // {
    //     return CurrencyHelper::format_currency_us_local($value, $this->currency_code);
    // }

}

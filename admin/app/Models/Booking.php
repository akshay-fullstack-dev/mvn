<?php

namespace App\Models;

use App\Enum\BookingEnum;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'vendor_id',
        'service_id',
        'address_id',
        'payment_id',
        'package_id',
        'vehicle_id',
        'booking_start_time',
        'booking_end_time',
        'booking_status',
        'booking_type',
        'addition_info',

    ];


    protected $dates = [
        'booking_start_time',
        'booking_end_time',
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/bookings/' . $this->getKey());
    }

    public function customer_details()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function booking_address()
    {
        return $this->belongsTo(UserAddress::class, 'address_id');
    }
    public function booking_status_history()
    {
        return $this->hasMany(BookingStatus::class);
    }
    public function booking_payment()
    {
        return $this->belongsTo(BookingPayment::class, 'payment_id');
    }
    public function booking_vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
    public function booking_vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
    public function booking_bills()
    {
        return $this->hasMany(BookingBill::class);
    }
    public function scopeActiveVendorService($query)
    {
        return $query->where('booking_status', BookingEnum::VendorAssignedOrVendorAccepted)->orWhere('booking_status', BookingEnum::VendorOutForService)
            ->orWhere('booking_status', BookingEnum::VendorStartedJob)
            ->orWhere('booking_status', BookingEnum::VendorReachedLocation);
    }
    public function scopeCompletedBookings($query)
    {
        return $query->where('booking_status', BookingEnum::VendorJobFinished);
    }
    public function payment()
    {
        return $this->belongsTo(BookingPayment::class, 'payment_id');
    }

    public function service_vendor()
    {
        return $this->hasMany(UserService::class, 'service_id', 'service_id');
    }
}

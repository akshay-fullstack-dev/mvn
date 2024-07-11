<?php

namespace App\Models;

use App\Enum\BookingEnum;
use App\Http\Resources\v1\Booking\BookingResource;
use App\Http\Resources\v1\Booking\BookingCollection;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    /**========================== set resource for use object =================================== */
    public function setResource($data)
    {
        return new BookingResource($data);
    }
    public function setResources($data)
    {
        return new BookingCollection($data);
    }

    public function customer_details()
    {
        return $this->belongsTo(User::class, 'user_id');
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
    // bookings scopes
    public function  scopeUpcomingBookings($query)
    {
        return $query->where('booking_status', BookingEnum::VendorAssignedOrVendorAccepted);
    }

    public function scopeCompletedOrCancelledBookings($query)
    {
        return $query->where('booking_status', BookingEnum::VendorJobFinished)->orWhere('booking_status', BookingEnum::bookingCancelled);
    }
    public function scopeOngoingBookings($query)
    {
        return $query->where(function ($query) {
            $query->orWhere('booking_status', BookingEnum::VendorOutForService)->orWhere('booking_status', BookingEnum::VendorStartedJob)->orWhere('booking_status', BookingEnum::VendorReachedLocation);
        });
    }
    public function scopeCompletedBookings($query)
    {
        return $query->where('booking_status', BookingEnum::VendorJobFinished);
    }
    public function scopeRequestedBookings($query)
    {
        return $query->where('booking_status', BookingEnum::BookingConfirmed);
    }
    public function scopeVendorBookingRequest($query)
    {
        return $query->where('booking_status', BookingEnum::BookingConfirmed);
    }

    public function scopeActiveVendorService($query)
    {
        return $query->where('booking_status', BookingEnum::VendorAssignedOrVendorAccepted)->orWhere('booking_status', BookingEnum::VendorOutForService)
            ->orWhere('booking_status', BookingEnum::VendorStartedJob)
            ->orWhere('booking_status', BookingEnum::VendorReachedLocation);
    }

    public function scopeOutForService($query)
    {
        return $query->where('booking_status', BookingEnum::VendorOutForService);
    }
    public function scopeRescheduleBooking($query)
    {
        // return $query->vendorBookingRequest()->
    }
    public function scopeCancelableBookings($query)
    {
        return $query->where('booking_status', BookingEnum::VendorAssignedOrVendorAccepted)->orWhere('booking_status', BookingEnum::BookingConfirmed);
    }

    public function scopeNotIncludedCancelledAndRejectedBookings($query)
    {
        return $query->where('booking_status', '!=', BookingEnum::bookingRejected)->where('booking_status', '!=', BookingEnum::bookingCancelled);
    }
    public function packages()
    {
        return $this->hasOne(Package::class, 'id', 'package_id');
    }
    public function scopeLatestBookings($query)
    {
        return $query->orderBy('booking_start_time', 'DESC');
    }
}

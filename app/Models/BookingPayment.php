<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingPayment extends Model
{
    protected $guarded = [];
    
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'payment_id');
    }
    public function bookingpackagemaintains()
    {
        return $this->belongsTo('App\Models\PackageMaintain');
    }
}

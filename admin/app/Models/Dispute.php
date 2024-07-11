<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Dispute extends Model
{
    protected $fillable = [
        'booking_id',
        'user_id',
        'message',
        'is_resolved',

    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url', 'change_status_url', 'user_resource_url', 'booking_resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/disputes/' . $this->getKey());
    }
    public function getUserResourceUrlAttribute()
    {
        return url('/admin/users/' . $this->user_id.'/viewDetails');
    }
    public function getBookingResourceUrlAttribute()
    {
        return url('/admin/bookings/' . $this->booking_id . '/view');
    }
    public function getChangeStatusUrlAttribute()
    {
        return url('/admin/disputes/' . $this->getKey() . '/change-status');
    }
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferralAmount extends Model
{
    protected $fillable = [
        'referral_amount',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/referral-amounts/'.$this->getKey());
    }
}

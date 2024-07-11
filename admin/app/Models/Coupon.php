<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'coupon_code',
        'coupon_discount',
        'coupon_max_amount',
        'coupon_min_amount',
        'coupon_name',
        'coupon_type',
        'end_date',
        'maximum_per_customer_use',
        'maximum_total_use',
        'start_date',
        'users_id',
        'coupon_description'

    ];


    protected $dates = [
        'start_date',
        'end_date',
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/coupons/' . $this->getKey());
    }
}

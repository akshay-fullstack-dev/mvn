<?php

namespace IntersoftCoupon\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use IntersoftCoupon\Http\Resources\CouponCollection;

class Coupon extends Model
{
    use SoftDeletes;
    public function setResources($service_data)
    {
        return new CouponCollection($service_data);
    }

    public function coupon_history()
    {
        return $this->hasMany(CouponHistory::class);
    }
}

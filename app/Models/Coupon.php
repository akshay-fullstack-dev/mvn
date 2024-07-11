<?php

namespace App\Models;

use App\Http\Resources\v1\Coupon\CouponCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

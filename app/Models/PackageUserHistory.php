<?php

namespace App\Models;

use App\Http\Resources\v1\Package\UserPackageHistoryCollection;
use App\Http\Resources\v1\Package\UserPackageHistoryResource;
use Illuminate\Database\Eloquent\Model;

class PackageUserHistory extends Model
{
    protected $fillable = ['user_id', '	package_id', 'order_id'];

    public function booking_by_order_id()
    {
        return $this->hasMany(Booking::class, 'order_id', 'order_id');
    }
    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }
    public function setResource($data)
    {
        return new UserPackageHistoryResource($data);
    }
    public function setResources($data)
    {
       
        return new UserPackageHistoryCollection($data);
    }
}

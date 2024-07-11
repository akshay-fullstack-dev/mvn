<?php

namespace App\Models;

use App\Http\Resources\v1\PackageBook\PackageBookListResource;
use Illuminate\Database\Eloquent\Model;

class PackageMaintain extends Model
{
    protected $guarded = [];

    public function setResource($data)
    {
       

        return new PackageBookListResource($data);
    }
    public function packages()
    {
        return $this->belongsTo('App\Models\Package', 'package_id', 'id');
    }

    public function bookings()
    {

        return $this->hasMany('App\Models\Booking', 'package_maintaince_id', 'id');

    }

}

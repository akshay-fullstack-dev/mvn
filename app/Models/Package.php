<?php

namespace App\Models;

use App\Enum\PackageEnum;
use App\Http\Resources\v1\Package\PackageResource;
use App\Http\Resources\v1\Service\PackageCollection;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;

class Package extends Model implements HasMedia
{
    use HasMediaTrait;
    public function scopeActivePackage($query, $timezone)
    {
        $current_time = Carbon::now()->timezone($timezone);
        return $query->where('status', PackageEnum::ACTIVE_PACKAGE)->whereDate('start_date', '<=', $current_time)->whereDate('end_date', '>', $current_time);
    }
    public function package_history()
    {
        return $this->hasMany(PackageUserHistory::class, 'package_id');
    }

    public function package_services()
    {
        return $this->hasMany(PackageService::class);
    }
    public function setResource($data)
    {
        return new PackageResource($data);
    }
    public function setResources($data)
    {
        return new PackageCollection($data);
    }
    public function packageMaintains()
    {
        return $this->hasMany('App\Models\PackageMaintain');
    }
    public function bookings()
    {
        return $this->hasMany('App\Models\Booking');
    }
}

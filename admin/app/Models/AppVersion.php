<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppVersion extends Model
{
    protected $fillable = [
        'app_package_id',
        'force_update',
        'message',
        'version',
        'code',
        'platform',

    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/app-versions/' . $this->getKey());
    }

    public function app_packages()
    {
        return $this->belongsTo(AppPackage::class, 'app_package_id');
    }
}

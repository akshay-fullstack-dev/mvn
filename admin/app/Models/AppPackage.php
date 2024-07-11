<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppPackage extends Model
{
    protected $fillable = [
        'bundle_id',
        'app_name',

    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/app-packages/' . $this->getKey());
    }
    public function app_version()
    {
        return $this->hasOne(AppVersion::class);
    }
}

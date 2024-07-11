<?php

namespace App\Models;

use App\Http\Resources\v1\Version\VersionResource;
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


    /* ************************ ACCESSOR ************************* */


    public function app_packages()
    {
        return $this->belongsTo(AppPackage::class, 'app_package_id');
    }
    public function setResource($data)
    {
        return new VersionResource($data);
    }
}

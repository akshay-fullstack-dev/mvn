<?php

namespace IntersoftNotification\App\Models;
class DeviceDetail extends \Illuminate\Database\Eloquent\Model
{
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageService extends Model
{
    public function services(){
        return $this->belongsTo('App\Models\Service','service_id','id');
    }
}

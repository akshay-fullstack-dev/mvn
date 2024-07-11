<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageMaintain extends Model
{
    protected $fillable = [
        'package_id',
        'user_id',
        'order_id',
        'transaction_id',
        'amount',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/package-maintains/'.$this->getKey());
    }

    public function users(){
        return $this->belongsTo(User::class ,'user_id','id');
    } 
    public function packages(){
        return $this->belongsTo('App\Models\Package' ,'package_id','id');
    }
}

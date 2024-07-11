<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SparePartsShopLocation extends Model
{
    protected $fillable = [
        'shop_name',
        'additional_shop_information',
        'country',
        'formatted_address',
        'city',
        'postal_code',
        'lat',
        'long',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/spare-parts-shop-locations/'.$this->getKey());
    }
}

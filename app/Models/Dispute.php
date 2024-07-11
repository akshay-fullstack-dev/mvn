<?php

namespace App\Models;

use App\Http\Resources\v1\Common\DisputeCollection;
use Illuminate\Database\Eloquent\Model;

class Dispute extends Model
{
     protected $guarded = [];
     public function setResources($service_data)
     {
          return new DisputeCollection($service_data);
     }

     public function booking()
     {
          return $this->belongsTo(Booking::class);
     }
}

<?php

namespace App\Models;

use App\Http\Resources\v1\Service\ServiceCategoryResource;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;

class ServiceCategory extends Model implements HasMedia
{
    use HasMediaTrait;
    protected $table = 'service_category';
    public function setResource($serviceCategoryData)
    {
        return new ServiceCategoryResource($serviceCategoryData);
    }
    public function service()
    {
        return $this->hasMany(Service::class, 'service_category_id');
    }
}

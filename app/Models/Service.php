<?php

namespace App\Models;

use App\Http\Resources\v1\Service\Service as ServiceService;
use App\Http\Resources\v1\Service\ServiceCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;

/**
 * App\Models\Service
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $approx_time
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserService[] $user_services
 * @property-read int|null $user_services_count
 * @method static \Illuminate\Database\Eloquent\Builder|Service newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service query()
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereApproxTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Service extends Model implements HasMedia
{
    use HasMediaTrait;
    use SoftDeletes;
    // set resource for response
    public function setResources($service_data)
    {
        return new ServiceCollection($service_data);
    }
    public function setResource($service)
    {
        return new ServiceService($service);
    }
    // user services 
    public function user_services()
    {
        return $this->hasMany(UserService::class, 'service_id');
    }
    public function service_inclusions()
    {
        return $this->hasMany(ServiceInclusion::class, 'service_id');
    }
}

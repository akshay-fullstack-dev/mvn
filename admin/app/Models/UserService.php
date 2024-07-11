<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserService
 *
 * @property int $id
 * @property int $user_id
 * @property int $service_id
 * @property float|null $price
 * @property string|null $time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $resource_url
 * @method static \Illuminate\Database\Eloquent\Builder|UserService newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserService newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserService query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserService whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserService whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserService wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserService whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserService whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserService whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserService whereUserId($value)
 * @mixin \Eloquent
 */
class UserService extends Model
{
    protected $fillable = [
        'user_id',
        'service_id',
        'price',
        'time',
    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/user-services/' . $this->getKey());
    }

    public function get_service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * App\Models\VendorRequestedService
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string|null $description
 * @property float|null $price
 * @property string|null $approx_time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read mixed $resource_url
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $user
 * @property-read int|null $user_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Vendor_requested_service_inclusion[] $vendorRequestedServiceInclusion
 * @property-read int|null $vendor_requested_service_inclusion_count
 * @method static \Illuminate\Database\Eloquent\Builder|VendorRequestedService newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VendorRequestedService newQuery()
 * @method static \Illuminate\Database\Query\Builder|VendorRequestedService onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|VendorRequestedService query()
 * @method static \Illuminate\Database\Eloquent\Builder|VendorRequestedService whereApproxTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VendorRequestedService whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VendorRequestedService whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VendorRequestedService whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VendorRequestedService whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VendorRequestedService whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VendorRequestedService wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VendorRequestedService whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VendorRequestedService whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|VendorRequestedService withTrashed()
 * @method static \Illuminate\Database\Query\Builder|VendorRequestedService withoutTrashed()
 * @mixin \Eloquent
 */
class VendorRequestedService extends Model implements HasMedia
{
    use HasMediaTrait;
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'price',
        'approx_time',

    ];
    protected $dates = [
        'created_at',
        'updated_at',

    ];
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/vendor-requested-services/' . $this->getKey());
    }
    public function user()
    {
        return $this->hasMany('App\Models\User', 'id', 'user_id');
    }
    public function vendorRequestedServiceInclusion()
    {
        return $this->hasMany('App\Models\Vendor_requested_service_inclusion', 'requested_service_id', 'id');
    }
    public function serviceCategory()
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id', 'id');
    }
}

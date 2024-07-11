<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media as MediaModel;
// use Spatie\MediaLibrary\HasMedia;
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
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|MediaModel[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Vendor_requested_service_inclusion[] $service_inclusion
 * @property-read int|null $service_inclusion_count
 * @method static \Illuminate\Database\Eloquent\Builder|VendorRequestedService newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VendorRequestedService newQuery()
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
 * @mixin \Eloquent
 */
class VendorRequestedService extends Model implements HasMedia
{
    use HasMediaTrait;
    protected $guarded = [];
    public function service_inclusion()
    {
        return $this->hasMany(Vendor_requested_service_inclusion::class, 'requested_service_id');
    }
}

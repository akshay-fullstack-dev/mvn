<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserTempAddress
 *
 * @property int $id
 * @property int $user_id
 * @property int $type
 * @property string $city
 * @property string $country
 * @property string $formatted_address
 * @property string $additional_info
 * @property float $latitude
 * @property float $longitude
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserTempAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTempAddress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTempAddress query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTempAddress whereAdditionalInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTempAddress whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTempAddress whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTempAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTempAddress whereFormattedAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTempAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTempAddress whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTempAddress whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTempAddress whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTempAddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTempAddress whereUserId($value)
 * @mixin \Eloquent
 */
class UserTempAddress extends Model
{
    protected $guarded = [];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DeviceDetail
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $device_id
 * @property string|null $device_token
 * @property string|null $build_version
 * @property string|null $platform
 * @property string|null $build
 * @property string|null $build_mode
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceDetail whereBuild($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceDetail whereBuildMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceDetail whereBuildVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceDetail whereDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceDetail whereDeviceToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceDetail wherePlatform($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceDetail whereUserId($value)
 * @mixin \Eloquent
 */
class DeviceDetail extends Model
{
    protected $guarded = [];
}

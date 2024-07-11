<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserOtp
 *
 * @property int $id
 * @property string|null $country_code
 * @property string|null $phone_number
 * @property string|null $email
 * @property int $otp
 * @property string $expired_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserOtp newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserOtp newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserOtp query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserOtp whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOtp whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOtp whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOtp whereExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOtp whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOtp whereOtp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOtp wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOtp whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class UserOtp extends Model
{
    protected $guarded = [];
}

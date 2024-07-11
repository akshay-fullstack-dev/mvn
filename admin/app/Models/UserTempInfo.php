<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserTempInfo
 *
 * @property int $id
 * @property int $user_id
 * @property string $first_name
 * @property string $last_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserTempInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTempInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTempInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTempInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTempInfo whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTempInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTempInfo whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTempInfo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTempInfo whereUserId($value)
 * @mixin \Eloquent
 */
class UserTempInfo extends Model
{
    protected $guarded = [];
}

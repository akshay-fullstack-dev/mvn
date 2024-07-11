<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Reason
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $type 1 block 2 reject
 * @method static \Illuminate\Database\Eloquent\Builder|Reason newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reason newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reason query()
 * @method static \Illuminate\Database\Eloquent\Builder|Reason whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reason whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reason whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reason whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reason whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reason whereUserId($value)
 * @mixin \Eloquent
 */
class Reason extends Model
{
  	protected $fillable = [
        'user_id',
        'reason',
        'type',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    


}

<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ServiceInclusion
 *
 * @property int $id
 * @property int $service_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceInclusion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceInclusion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceInclusion query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceInclusion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceInclusion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceInclusion whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceInclusion whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceInclusion whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ServiceInclusion extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'service_id',
    
    ];
}

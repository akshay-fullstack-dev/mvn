<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Vendor_requested_service_inclusion
 *
 * @property int $id
 * @property int $requested_service_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor_requested_service_inclusion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor_requested_service_inclusion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor_requested_service_inclusion query()
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor_requested_service_inclusion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor_requested_service_inclusion whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor_requested_service_inclusion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor_requested_service_inclusion whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor_requested_service_inclusion whereRequestedServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor_requested_service_inclusion whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Vendor_requested_service_inclusion extends Model
{
    use SoftDeletes;
    protected $guarded = [];
}

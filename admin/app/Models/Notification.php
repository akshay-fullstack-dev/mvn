<?php

namespace App\Models;

use App\Http\Resources\Api_v1\Notification\NotificationResource;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Notification
 *
 * @property int $id
 * @property int $send_by
 * @property int $send_to
 * @property string $notification_type
 * @property string $title
 * @property string|null $description
 * @property int $is_read
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereIsRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereNotificationType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereSendBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereSendTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Notification extends Model
{
    const generalNotification = 1;
    const chatNotification = 15;
    const disputeNotification = 16;
    const notRead = false;
    protected $guarded = [];

    public function setResource($notification)
    {
        return new NotificationResource($notification);
    }
}

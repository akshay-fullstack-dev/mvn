<?php

namespace App\Models;

use App\Http\Resources\v1\Notification\NotificationCollection;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    const generalNotification = 1;
    const chatNotification = 2;
    const notRead = false;
    protected $guarded = [];
    public function setResources($notification_data)
    {
        return new NotificationCollection($notification_data);
    }
}

<?php

namespace IntersoftNotification\App\Models;
use Illuminate\Database\Eloquent\Model;
use IntersoftNotification\App\Http\Resources\NotificationCollection;

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

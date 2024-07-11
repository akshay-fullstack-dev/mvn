<?php

namespace App\Http\Resources\v1\Notification;

use Illuminate\Http\Resources\Json\JsonResource;

class Notification extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title ?? "",
            'description' => $this->description ?? "",
            'is_read' => $this->is_read,
            'type' => $this->notification_type,
            'date_time' => date('Y-m-d H:i:s', strtotime($this->created_at))
        ];
    }
}

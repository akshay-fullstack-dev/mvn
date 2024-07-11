<?php

namespace IntersoftChat\App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserMessageListingResource extends JsonResource
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
            'message_id' => $this->id,
            'sender_id' => $this->user_id,
            'receiver_id' => $this->receiver_id,
            'message' => $this->message,
            'message_type' => $this->message_type,
            'message_time' => $this->message_time,
        ];
    }
}

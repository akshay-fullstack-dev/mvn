<?php

namespace IntersoftChat\App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatInboxListing extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $last_message = null;
        if (isset($this->user_conversation)) {
            $last_message =  [
                'message_id' =>  $this->user_conversation->id,
                'message' =>  $this->user_conversation->message ?? "",
                'message_type' =>  $this->user_conversation->message_type ?? "",
                'message_time' =>  $this->user_conversation->message_time ?? "",
            ];
        }
        return [
            'conversation_id' => $this->id,
            'user_id' => $this->chat_user->id ?? "",
            'user_name' => ($this->chat_user->first_name ?? "") . " " . ($this->chat_user->last_name ?? ""),
            'user_email' => $this->chat_user->email ?? "",
            'user_profile_picture' => $this->chat_user->profile_picture ?? "",
            'expiry_at' => $this->expiry_date,
            'user_last_message' => $last_message
        ];
    }
}

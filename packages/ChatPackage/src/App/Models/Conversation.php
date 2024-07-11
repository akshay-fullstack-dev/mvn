<?php

namespace IntersoftChat\App\Models;

use Illuminate\Database\Eloquent\Model;
use IntersoftChat\App\Http\Resources\ChatInboxListing;

class Conversation extends Model
{
    protected $guarded = [];
    public function conversation_messages()
    {
        return $this->hasMany(ConversationMessage::class, 'conversation_id');
    }
    public function setResource($data)
    {
        return new ChatInboxListing($data);
        
    }
}

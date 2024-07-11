<?php

namespace IntersoftChat\App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use IntersoftChat\App\Http\Resources\UserMessageListingResource;

class ConversationMessage extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $guarded = [];
    public function sender_user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function send_to_user()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
    public function setResource($data)
    {
        return new UserMessageListingResource($data);
    }
}

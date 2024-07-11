<?php

namespace IntersoftChat\App\Helpers;

use App\Enums\WeekDays;

class ChatHelper
{
  public static function get_send_message_data($request, $user_id)
  {
    return [
      'user_id' => $user_id,
      'receiver_id' => $request->receiver_id,
      'message' => $request->message,
      'message_type' => $request->message_type,
      'message_time' => $request->message_time,
    ];
  }
}

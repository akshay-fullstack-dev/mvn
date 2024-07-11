<?php

namespace IntersoftChat\App\Services;

use IntersoftChat\App\Enums\ChatEnum;
use App\Exceptions\BadRequestException;
use App\Exceptions\InternalServerException;
use App\Exceptions\RecordNotFoundException;
use App\Helpers\V1\PushNotificationHelper;
use IntersoftChat\App\Helpers;
use App\Helpers\V1\PushNotificationService;
use IntersoftChat\App\Http\Requests as ChatRequest;
use App\Models\Notification;
use App\Repositories\Interfaces\IAuthUserRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use IntersoftChat\App\Http\Resources\ChatInboxListing;
use IntersoftChat\App\Repositories\Interfaces\IConversationRepository as InterfacesIConversationRepository;
use IntersoftChat\App\Services\Interfaces\IChatService;

class ChatService implements IChatService
{
  private $conversationRepository;
  private $authRepository;
  public function __construct(
    InterfacesIConversationRepository $conversationRepository,
    IAuthUserRepository $authRepository
  ) {
    $this->conversationRepository = $conversationRepository;
    $this->authRepository = $authRepository;
  }
  public function sendMessage(ChatRequest\SendMessageRequest $request)
  {
    $user = Auth::user();
    $chat_data = Helpers\ChatHelper::get_send_message_data($request, $user->id);
    $getConversation = $this->conversationRepository->getConversation($user->id, $chat_data['receiver_id']);
    if (!$getConversation)
      throw new BadRequestException('You cannot chat with this user.');
    $getConversation->conversation_messages()->create($chat_data);
    // send notification 
    $notification_description = '';
    if ($chat_data['message_type'] == ChatEnum::type_message)
      $notification_description = $chat_data['message'];
    else
      $notification_description = "You have new message from $user->name";
    $notification_title = $user->name;
    PushNotificationHelper::send($user->id,  $chat_data['receiver_id'], $notification_title, $notification_description, Notification::chatNotification, false);
    return true;
  }

  // get the inbox user listing for those user who can message them
  public function inboxListing(ChatRequest\InboxListingRequest $request)
  {
    $current_device_time = date("Y-m-d h:i:s", strtotime($request->header('Device-Time', Carbon::now())));
    $record_per_page = $request->item_per_page ?? ChatEnum::record_per_page;
    $user = Auth::user();
    $getConversation = $this->conversationRepository->getAllOpenConversation($user->id, $current_device_time, $record_per_page);
    if (!$getConversation->count() > 0)
      throw new RecordNotFoundException('Not found any active chat right now or You don\'t have any at this moment.Please try again after a while.');
    return ChatInboxListing::collection($this->conservationDataResponse($user, $current_device_time, $record_per_page));
  }

  // send the user message listing 
  public function messageListing(ChatRequest\MessageListingRequest $request)
  {
    $record_per_page = $request->item_per_page ?? ChatEnum::record_per_page;
    $user = Auth::user();
    $getConversation = $this->conversationRepository->getConversation($request->sender_id, $request->receiver_id);
    if (!$getConversation)
      throw new BadRequestException('No messages found.');
    $messages = $this->conversationRepository->getConversationMessages($getConversation, $record_per_page);
    if (!$messages->count() > 0) {
      throw new BadRequestException('No messages found.');
    }
    return ChatInboxListing::collection($messages);
  }

  // delete chat
  public function deleteChat(ChatRequest\DeleteChatRequest $request)
  {
    $user = Auth::user();
    $getConversation = $this->conversationRepository->getConversation($user->id, $request->chat_user_id);
    if (!$getConversation)
      throw new BadRequestException('No messages found.');
    $all_message =  $getConversation->conversation_messages()->get();
    if (!$all_message->count() > 0)
      throw new RecordNotFoundException('No messages found.');
    $delete_status =   $getConversation->conversation_messages()->delete();
    if (!$delete_status)
      throw new InternalServerException('Something went wrong.Please try again alter.');
    return true;
  }

  public function createChat(ChatRequest\CreateChatRequest $request)
  {
    $user = Auth::user();
    $this->conversationRepository->createNewConversationOrEnableIt($user->id, $request->second_user_id);
    return $this->getSingleConversation($user->id, $request->second_user_id);
  }


  private function getSingleConversation($user_id, $receiver_id)
  {
    $conversation = $this->conversationRepository->getConversation($user_id, $receiver_id);
    $conversation->user_conversation = $conversation->conversation_messages()->latest()->first();
    $chat_user_id = '';
    if ($user_id != $conversation->conversation_first_user_id) {
      $chat_user_id = $conversation->conversation_first_user_id;
    } else {
      $chat_user_id = $conversation->conversation_second_user_id;
    }
    $conversation->chat_user = $this->authRepository->get_user(['id' => $chat_user_id]);
    return  $conversation;
  }
  // this function is used to return the conversation response data 
  private function conservationDataResponse($user, $current_device_time, $record_per_page)
  {
    $getConversation = $this->conversationRepository->getAllOpenConversation($user->id, $current_device_time, $record_per_page);
    foreach ($getConversation as $conversation) {
      $conversation->user_conversation = $conversation->conversation_messages()->latest()->first();
      $chat_user_id = '';
      if ($conversation->conversation_first_user_id != $user->id)
        $chat_user_id = $conversation->conversation_first_user_id;
      else
        $chat_user_id = $conversation->conversation_second_user_id;
      $conversation->chat_user = $this->authRepository->get_user(['id' => $chat_user_id]);
    }
    return $getConversation;
  }
}

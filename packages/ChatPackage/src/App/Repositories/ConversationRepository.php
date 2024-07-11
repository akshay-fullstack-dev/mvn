<?php

namespace IntersoftChat\App\Repositories;

use App\Repositories\GenericRepository;
use IntersoftChat\App\Enums\ChatEnum;
use IntersoftChat\App\Models\Conversation;
use IntersoftChat\App\Repositories\Interfaces\IConversationRepository;

class ConversationRepository extends GenericRepository implements IConversationRepository
{
	public function model()
	{
		return Conversation::class;
	}
	public function getConversation($user_id, $receiver_id)
	{
		$conversation = $this->getUsersConversation($user_id, $receiver_id);
		if (!$conversation) {
			return null;
		} else if ($conversation->status == ChatEnum::closedChat) {
			return null;
		}
		// !removed chat conversation expiry date condition
		// else if ($conversation->expiry_date < Carbon::now())
		// 	return null;
		else {
			return $conversation;
		}
	}
	private function getUsersConversation($user_id, $receiver_id)
	{
		return $this->model->where(function ($query) use ($user_id, $receiver_id) {
			$query->where(['conversation_first_user_id' => $user_id, 'conversation_second_user_id' => $receiver_id])
				->orWhere(function ($query) use ($user_id, $receiver_id) {
					$query->Where(['conversation_first_user_id' => $receiver_id, 'conversation_second_user_id' => $user_id]);
				});
		})->first();
	}

	public function createNewConversationOrEnableIt($user_id, $host_id, $chat_expiry_date = null)
	{
		$conversation = $this->getUsersConversation($user_id, $host_id);
		if (!$conversation) {
			$this->model->create(['conversation_first_user_id' => $user_id, 'conversation_second_user_id' => $host_id, 'expiry_date' => $chat_expiry_date]);
			return true;
		}
		// if chat is closed then enable it
		if ($conversation->status == ChatEnum::closedChat) {
			$conversation->status = ChatEnum::openChat;
			$conversation->save();
		}
		// if chat expiry date is less of the booking requested time then update the chat expiry time
		if ($conversation->expiry_date < $chat_expiry_date) {
			$conversation->expiry_date = $chat_expiry_date;
			$conversation->save();
		}
		return true;
	}

	// get all conversation
	// $request->sender_id, $request->receiver_id,
	public function getAllOpenConversation($user_id, $current_device_time = null, $record_per_page = '')
	{
		$conversation = $this->model
			// for open conversation conditions
			->where('status', ChatEnum::openChat)
			// !chat expire condition is  commented for now
			// ->where('expiry_date', '>', $current_device_time) 
			// get the user based condition
			->where(function ($query) use ($user_id) {
				$query->where('conversation_first_user_id', $user_id);
				$query->orWhere('conversation_second_user_id', $user_id);
			})
			->with(['conversation_messages' => function ($query) {
				$query->latest()->first();
			}])->latest();
		if ($record_per_page != '') {
			$result =	$conversation->paginate($record_per_page);
		} else {
			$result = $conversation->get();
		}
		return $result;
	}

	public function getConversationMessages($getConversation, $record_per_page)
	{
		return $getConversation->conversation_messages()->latest()->paginate($record_per_page);
	}
}

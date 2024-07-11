<?php

namespace IntersoftChat\App\Repositories;

use App\Repositories\GenericRepository;
use IntersoftChat\App\Repositories\Interfaces\IConversationMessageRepository;

class ConversationMessageRepository extends GenericRepository implements IConversationMessageRepository
{
	public function model()
	{
		return ConversationMessage::class;
	}

}

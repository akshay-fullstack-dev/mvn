<?php

namespace IntersoftChat\App\Http\Controllers;
use App\Http\Controllers\Controller;
use IntersoftChat\App\Http\Requests as ChatRequest;
use IntersoftChat\App\Services\Interfaces\IChatService;

Class ChatController extends Controller
{
  private $chatService;
  public function __construct(IChatService $chatService)
  {
    $this->chatService = $chatService;
  }
  public function sendMessage(ChatRequest\SendMessageRequest $request)
  {
    return  $this->chatService->sendMessage($request);
  }

  public function inboxListing(ChatRequest\InboxListingRequest $request)
  {
    return $this->chatService->inboxListing($request);
  }
  public function messageListing(ChatRequest\MessageListingRequest $request)
  {
    return $this->chatService->messageListing($request);
  }
  public function deleteChat(ChatRequest\DeleteChatRequest $request)
  {
    return $this->chatService->deleteChat($request);
  }

  public function createChat(ChatRequest\CreateChatRequest $request)
  {
    return $this->chatService->createChat($request);
  }
}

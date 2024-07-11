<?php

namespace App\Traits\V1;

use App\Http\Requests\V1\Notification\GetNotificationRequest;
use App\Services\Interfaces\INotificationService;
use Request;

trait NotificationActions
{
	private $notificationService;

	public function __construct(INotificationService  $notificationService)
	{
		$this->notificationService = $notificationService;
	}
	public function getNotifications(GetNotificationRequest $request)
	{
		return $this->notificationService->getNotifications($request);
	}
	public function getNotificationCount(Request $request)
	{
		return $this->notificationService->getNotificationCount($request);
	}
}

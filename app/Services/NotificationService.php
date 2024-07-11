<?php

namespace App\Services;

use App\Exceptions\RecordNotFoundException;
use App\Http\Requests\v1\Notification\GetNotificationRequest;
use App\Repositories\Interfaces\INotificationRepository;
use App\Services\Interfaces\INotificationService;
use Illuminate\Support\Facades\Auth;

class NotificationService implements INotificationService
{
	private $user;
	private $notificationRepository;
	public function __construct(INotificationRepository $notificationRepository)
	{

		$this->notificationRepository = $notificationRepository;
	}
	public function getNotificationCount()
	{
		$this->user = Auth::user();
		$notification = $this->notificationRepository->getNotifications($this->user->id);
		if (!$notification)
			throw new RecordNotFoundException(trans('Api/v1/notification.no_notification_found'));
		return ['notification_count' => $notification->count()];
	}

	// get all notification
	public function getNotifications(GetNotificationRequest $request)
	{
		$this->user = Auth::user();
		$record_per_page = $request->item_per_page  ?? env('PAGINATE_PRODUCT_PER_PAGE', 10);
		$notification = $this->notificationRepository->getNotifications($this->user->id, false, $record_per_page);
		if (!$notification)
			throw new RecordNotFoundException(trans('Api/v1/notification.notification_not_found'));
		$read_notification = $notification->where('is_read', false)->pluck('id')->toArray();
		// update the status to read
		$this->notificationRepository->updateReadNotificationsStatus($read_notification);
		return $notification;
		// return new  NotificationCollection($notification);
	}
}

<?php

namespace App\Repositories;

use App\Models\Notification;
use App\Repositories\GenericRepository;
use App\Repositories\Interfaces\INotificationRepository;

class NotificationRepository extends GenericRepository implements INotificationRepository
{
	public function model()
	{
		return Notification::class;
	}
	public function getNotifications($user_id, $onlyUnRead = true, $pagination_record_per_page = false)
	{
		$notification =	Notification::where('send_to',  $user_id)->latest();
		// if get unread notification
		if ($onlyUnRead)
			$notification->where('is_read', Notification::notRead);

		if ($pagination_record_per_page) {
			$result = $notification->Paginate($pagination_record_per_page);
		} else {
			$result = $notification->get();
		}
		if ($result->count() > 0) {
			return $result;
		}
		return false;
	}

	public function updateReadNotificationsStatus(array $notification_ids)
	{
		return $this->model->whereIn('id', $notification_ids)->update(['is_read' => true]);
	}
}

<?php

namespace App\Repositories\Interfaces;

interface INotificationRepository extends IGenericRepository
{
	public function getNotifications($user_id, $is_read = true, $pagination_record_per_page = false);
}

<?php
namespace App\Repositories\Notification;

interface NotificationRepositoryInterface
{
    public function list($request);
    public function markAsRead($id);
}

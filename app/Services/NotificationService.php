<?php

namespace App\Services;

use App\Repositories\Notification\NotificationRepositoryInterface;
use App\Notifications\AlertNotification;
use Pusher\Pusher;

class NotificationService {
    protected $notificationRepository;


    public function __construct(NotificationRepositoryInterface $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }


    public function list($request){
        $data = $this->notificationRepository->list($request);
        return $data;
    }

    public function create($request){
        $notification = $this->filterData($request);
        $data = $this->notificationRepository->create($notification);
        $user = auth()->user();
        $user->notify(new AlertNotification($data));
        $options = array(
            'cluster' => 'ap1',
            'encrypted' => true
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );
        $pusher->trigger('NotificationEvent', 'send-message', $data);
        return $data;
    }
    

    public function markAsRead($id){
        $this->notificationRepository->markAsRead($id);
    }

    private function filterData($request): array{
        $data = $request->all();
        return array(
            'title' => $data['title'] ?? null,
            'content' => $data['content'] ?? null,
            'status' => $data['status'] ?? null
        );
    }
}
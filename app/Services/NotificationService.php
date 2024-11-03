<?php

namespace App\Services;

use App\Repositories\Notification\NotificationRepositoryInterface;
use App\Notifications\AlertNotification;
use App\Traits\PusherTrait;
use Pusher\Pusher;

class NotificationService {
    use PusherTrait;
    protected $notificationRepository;


    public function __construct(NotificationRepositoryInterface $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }


    public function list($request){
        $data = $this->notificationRepository->list($request);
        return $data;
    }

    public function find($id){
        $data = $this->notificationRepository->find($id);
        return $data;
    }

    public function customer_list($request){
        $data = $this->notificationRepository->listByGroupTitle($request);
        return $data;
    }

    public function partner_list($request){
        $data = $this->notificationRepository->listByGroupTitle($request);
        return $data;
    }

    public function create($request){
        $notification = $this->filterData($request);
        $data = $this->notificationRepository->create($notification);
        $user = auth()->user();
        $user->notify(new AlertNotification($data));
        $this->sendNotification([
            'message' => $notification['title']
        ]);
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


    public function sendNotification($data = array(
        'message' => '',
    ))
    {
        $this->triggerEvent('notify-channel', 'notify-event', $data);
        return response()->json(['status' => 'Notification sent!']);
    }

    public function destroy($id){
        $this->notificationRepository->delete($id);
    }
}
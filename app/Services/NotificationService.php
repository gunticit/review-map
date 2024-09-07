<?php

namespace App\Services;

use App\Repositories\Notification\NotificationRepositoryInterface;

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
        return $data;
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
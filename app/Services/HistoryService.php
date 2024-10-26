<?php

namespace App\Services;

use App\Repositories\History\HistoryRepositoryInterface;

class HistoryService {
    protected $historyRepository;


    public function __construct(HistoryRepositoryInterface $historyRepository)
    {
        $this->historyRepository = $historyRepository;
    }


    public function list($request){
        $request = $request->merge([
            'order_by' => array(
                'id' => 'desc'
            )
        ]);
        $data = $this->historyRepository->list($request);
        return $data;
    }

    public function create($request){
        $history = $this->filterData($request);
        $data = $this->historyRepository->create($history);
        return $data;
    }

    private function filterData($request): array{
        $data = is_array($request) ? $request : $request->all();
        return array(
            'content' => $data['content'] ?? null,
            'user_id' => $data['user_id'] ?? null
        );
    }
}
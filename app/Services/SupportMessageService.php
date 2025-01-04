<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Repositories\Support\SupportMessageRepository;
use App\Http\Resources\SupportResource;
use App\Models\Support;
use Illuminate\Validation\ValidationException;

class SupportMessageService {
    protected $supportMessageRepository;

    public function __construct(SupportMessageRepository $supportMessageRepository)
    {
        $this->supportMessageRepository = $supportMessageRepository;
    }

    public function create($request){
        $data = $this->filterData($request);
        return $this->supportMessageRepository->create($data);
    }

    private function filterData($request): array{
        $key_ables = array(
            'support_id' => 'support_id', 
            'send_id' => 'send_id', 
            'receive_id' => 'receive_id', 
            'parent_id' => 'parent_id', 
            'message' => 'message', 
            'filepath' => 'file_path',
            'type' => 'type'
        );
        $data = array();
        foreach ($key_ables as $key => $key_able) {
            if(!empty($request[$key_able])){
                $data[$key] = $request[$key_able];
            }
        }
        return $data;
    }
}
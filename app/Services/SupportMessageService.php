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
        $request = $request->merge(['send_id' => Auth::user()->id]);
        $data = $this->filterData($request);
        return $this->supportMessageRepository->create($data);
    }

    private function filterData($request): array{
        $data = $request->all();
        return array(
            'support_id' => $data['support_id'] ?? null,
            'send_id' => $data['send_id'] ?? null,
            'receive_id' => $data['receive_id'] ?? null,
            'parent_id' => $data['parent_id'] ?? null,
            'message' => $data['message'] ?? null
        );
    }
}
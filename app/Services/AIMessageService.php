<?php

namespace App\Services;

use App\Repositories\AIMessage\AIMessageRepository;
use Illuminate\Validation\ValidationException;

class AIMessageService {
    protected $AIMessageRepository;



    public function __construct(AIMessageRepository $AIMessageRepository)
    {
        $this->AIMessageRepository = $AIMessageRepository;
    }

    /**
     * Authenticates the AIMessage with the given credentials.
     *
     * @param array $credentials The AIMessage's login credentials.
     * @return mixed|null The authenticated AIMessage if successful, null otherwise.
     * @throws ValidationException
     */

    public function list($request){
        $data = $this->AIMessageRepository->list($request);
        return $data;
    }

    public function create($request){
        $AIMessage = $this->filterData($request);
        $data = $this->AIMessageRepository->create($AIMessage);
        return $data;
    }

    public function renderMessageByAI($request){
    }
}
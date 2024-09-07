<?php

namespace App\Services;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Support\SupportRepositoryInterface;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\SupportResource;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class SupportService {
    protected $supportRepository;

    public function __construct(SupportRepositoryInterface $supportRepository)
    {
        $this->supportRepository = $supportRepository;
    }

    /**
     * Authenticates the project with the given credentials.
     *
     * @param array $credentials The project's login credentials.
     * @return mixed|null The authenticated project if successful, null otherwise.
     * @throws ValidationException
     */

    public function list($request){
        $supports = $this->supportRepository->list($request);
        $data = SupportResource::collection($supports)->resource;
        return $data;
    }

    public function create($request){
        $data = $this->filterData($request);
        $data = $this->supportRepository->create($data);
        return $data;
    }

    public function show($id){
        $data = $this->supportRepository->find($id);
        return $data;
    }

    public function update($request, $id){
        $data = $this->filterData($request);
        $data = $this->supportRepository->update($data, $id);
        return $data; 
    }


    private function filterData($request): array{
        $data = $request->all();
        return array(
            'title' => $data['title'] ?? null,
            'department_id' => $data['department_id'] ?? null,
            'project_id' => $data['project_id'] ?? null,
            'content' => $data['content'] ?? null,
            'filepath' => $data['filepath'] ?? null,
            'status' => $data['status'] ?? null
        );
    }
}
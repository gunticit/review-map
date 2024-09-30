<?php

namespace App\Services;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Mission\MissionRepositoryInterface;
use App\Http\Resources\MissionResource;
use App\Models\Mission;
use Illuminate\Validation\ValidationException;

class MissionService {
    protected $missionRepository;

    public function __construct(MissionRepositoryInterface $missionRepository)
    {
        $this->missionRepository = $missionRepository;
    }

    /**
     * Authenticates the project with the given credentials.
     *
     * @param array $credentials The project's login credentials.
     * @return mixed|null The authenticated project if successful, null otherwise.
     * @throws ValidationException
     */

    public function list($request){
        $supports = $this->missionRepository->list($request);
        $data = SupportResource::collection($supports)->resource;
        return $data;
    }

    public function getRandomMission($request){
        $data = $this->missionRepository->getRandomMission($request);
        return $data;
    }
}
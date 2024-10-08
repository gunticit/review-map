<?php

namespace App\Services;

use App\Repositories\Mission\MissionRepositoryInterface;
use App\Http\Resources\MissionResource;
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
        $data = MissionResource::collection($supports)->resource;
        return $data;
    }

    public function find($id){
        $mission = $this->missionRepository->find($id);
        dd($mission);
        $mission = new MissionResource($mission);
        return $mission;
    }

    public function update($request, $id){
        $mission = $this->missionRepository->update([
            'status' => 1,
            'link_confirm' => $request->link_confirm ?? '',
        ], $id);
        return $mission;
    }

    public function getRandomMission($request){
        $data = $this->missionRepository->getRandomMission($request);
        return $data;
    }
}
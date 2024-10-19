<?php

namespace App\Services;

<<<<<<< HEAD
use App\Http\Resources\MisionResource;
use App\Repositories\Mission\MissionRepositoryInterface;
=======
use App\Repositories\Mission\MissionRepositoryInterface;
use App\Http\Resources\MissionResource;
>>>>>>> c2294c75717a8cfde6cbf65228150dd4bf8dbd3e
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
<<<<<<< HEAD
        $data = MisionResource::collection($supports)->resource;
=======
        $data = MissionResource::collection($supports)->resource;
>>>>>>> c2294c75717a8cfde6cbf65228150dd4bf8dbd3e
        return $data;
    }

    public function find($id){
        $mission = $this->missionRepository->find($id);
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
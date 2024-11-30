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
        $query = $this->missionRepository->query();
        $query->with(['comments','images','project']);
        $mission = $query->find($id);
        return $mission;
    }

    public function update($request, $id){
        $mission_info = $this->find($id);
        $status = 4; // Admin Duyệt
        if(!empty($mission->image_id)){
            $status = 4; // Nếu câu hỏi có hình ảnh thì admin duyệt
        }
        $mission = $this->missionRepository->update([
            'status' => $status,
            'link_confirm' => $request->link_confirm ?? '',
        ], $id);

        return $mission;
    }

    public function updateStatus($request, $id){
        $mission = $this->missionRepository->update([
            'status' => $request->status,
        ], $id);
        if($request->status == 1){
            $user_id = $mission['user_id'] ?? null;
            if($user_id){
                $this->
            }
        }
        return $mission;
    }

    public function getRandomMission($request){
        $data = $this->missionRepository->getRandomMission($request);
        return $data;
    }

    public function getPrice($request){
        return 0;
    }

    public function updateNoImage($request, $id){
        $mission = $this->missionRepository->find($id);
        $count_check = $mission->num_check ?? 0;
        return $this->missionRepository->update([
            'no_image' => true,
            'num_check' => $count_check + 1
        ], $id);
    }

    public function updateNoReview($request, $id){
        $mission = $this->missionRepository->find($id);
        $count_check = $mission->num_check ?? 0;
        return $this->missionRepository->update([
            'no_review' => true,
            'num_check' => $count_check + 1
        ], $id);
    }
}
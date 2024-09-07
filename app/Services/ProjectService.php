<?php

namespace App\Services;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Project\ProjectRepositoryInterface;
use App\Http\Resources\ProjectResource;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ProjectService {
    protected $projectRepository;

    public function __construct(ProjectRepositoryInterface $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    /**
     * Authenticates the project with the given credentials.
     *
     * @param array $credentials The project's login credentials.
     * @return mixed|null The authenticated project if successful, null otherwise.
     * @throws ValidationException
     */

    public function list($request){
        $projects = $this->projectRepository->list($request);
        $projects = ProjectResource::collection($projects)->resource;
        $working = 0;
        $stopped = 0;
        foreach($projects as $project){
            if($project->status == 1){
                $working++;
            }
            if($project->status == 4){
                $stopped++;
            }
        }
        $data = array(
            'projects' => $projects,
            'total' => count($projects),
            'working' => $working,
            'stopped' => $stopped
        );
        return $data;
    }

    public function create($request){
        $project = $this->filterData($request);
        $data = $this->projectRepository->create($project);
        return $data;
    }

    public function show($id){
        $data = $this->projectRepository->find($id);
        return $data;
    }

    public function update($request, $id){
        $project = $this->filterData($request);
        $data = $this->projectRepository->update($project, $id);
        return $data; 
    }


    private function filterData($request): array{
        $data = $request->all();
        return array(
            'name' => $data['name'] ?? null,
            'description' => $data['description'] ?? null,
            'package' => $data['package'] ?? null,
            'is_slow' => $data['is_slow'] ?? null,
            'point_slow' => $data['point_slow'] ?? null,
            'keyword' => $data['keyword'] ?? null,
            'latitude' => $data['latitude'] ?? null,
            'longitude' => $data['longitude'] ?? null,
            'place_id' => $data['place_id'] ?? null,
            'has_image' => $data['has_image'] ?? null,
            'address_google' => $data['address_google'] ?? null,
            'telephone_google' => $data['telephone_google'] ?? null,
            'rating_google' => $data['rating_google'] ?? null,
            'total_rating_google' => $data['total_rating_google'] ?? null,
            'rating_desire' => $data['rating_desire'] ?? null,
            'status' => $data['status'] ?? 1,
        );
    }
}
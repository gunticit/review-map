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

    private function filterData($request): array{
        $data = $request->all();
        return array(
            'name' => $data['name'] ?? null,
            'url_map' => $data['url_map'] ?? null,
            'description' => $data['description'] ?? null,
            'package' => $data['package'] ?? null,
            'is_slow' => $data['is_slow'] ?? null,
            'keyword' => $data['keyword'] ?? null,
            'has_image' => $data['has_image'] ?? null,
            'description' => $data['description'] ?? null,
            'status' => $data['status'] ?? 1,
        );
    }
}
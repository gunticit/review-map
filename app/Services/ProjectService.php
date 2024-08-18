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
        $project = $this->projectRepository->list($request);
        return $project;
    }

    public function create($request){
        $data = $this->filterData($request);
        $project = $this->projectRepository->create($data);
        return $project;
    }

    private function filterData($request): array{
        $data = $request->all();
        return array(
            'name' => $data['name'],
            'email' => $data['email'],
            'telephone' => $data['telephone'],
        );
    }
}
<?php

namespace App\Services;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ProjectImage\ProjectImageRepositoryInterface;
use App\Http\Resources\ProjectImageResource;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ProjectImageService {
    protected $projectImageRepository;

    public function __construct(ProjectImageRepositoryInterface $projectImageRepository)
    {
        $this->projectImageRepository = $projectImageRepository;
    }

    /**
     * Authenticates the projectImage with the given credentials.
     *
     * @param array $credentials The projectImage's login credentials.
     * @return mixed|null The authenticated projectImage if successful, null otherwise.
     * @throws ValidationException
     */

    public function list($request){
        $projectImages = $this->projectImageRepository->list($request);
        $projectImages = ProjectImageResource::collection($projectImages)->resource;
        $working = 0;
        $stopped = 0;
        foreach($projectImages as $projectImage){
            if($projectImage->status == 1){
                $working++;
            }
            if($projectImage->status == 4){
                $stopped++;
            }
        }
        $data = array(
            'projectImages' => $projectImages,
            'total' => count($projectImages),
            'working' => $working,
            'stopped' => $stopped
        );
        return $data;
    }

    public function create($request){
        $projectImage = $this->filterData($request);
        $data = $this->projectImageRepository->create($projectImage);
        return $data;
    }

    public function createDataImages($request, $project_id){
        $projectImage = $this->filterData($request);
        $data = array();
        if(!empty($projectImage['images'])){
            $this->projectImageRepository->deleteByKey('project_id',$project_id);
            foreach($projectImage['images'] as $image){
                $data[] = array(
                    'image_url' => $image,
                    'project_id' => $project_id
                );
            }
            $this->projectImageRepository->insert($data);
        }
        return $data;
    }

    private function filterData($request): array{
        $data = $request->all();
        return array(
            'images' => $data['images'] ?? null,
        );
    }
}
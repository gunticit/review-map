<?php

namespace App\Services;

use App\Repositories\ProjectImage\ProjectImageRepositoryInterface;
use App\Http\Resources\ProjectImageResource;
use App\Models\Project;
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
            if($projectImage->status == Project::WORKING_PROJECT){
                $working++;
            }
            if($projectImage->status == Project::STOPPED_PROJECT){
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

    public function update($request, $id){
        $data = $this->getData($request);
        return $this->projectImageRepository->update($data, $id);
    }

    public function findImageByProject($project_id){
        $data = $this->projectImageRepository->findImageByProject($project_id);
        return $data;
    }

    public function createDataImages($request, $project_id){
        $data = array();
        if ($request->hasFile('files')) {
            $this->projectImageRepository->deleteByKey('project_id',$project_id);
            $folder = 'uploads' . '/' . date('Y-m') . '/' . date('d') . '/' . $project_id;
            foreach ($request->file('files') as $image) {
                $path = $image->store($folder, 'public');
                $data[] = array(
                    'image_url' => $path,
                    'project_id' => $project_id
                );
            }
            $this->projectImageRepository->insert($data);
        }
        return $data;
    }

    public function getData($request){
        return array(
            'project_id' => $data->project_id ?? null,
            'image_url' => $request->image_url ?? null,
            'is_used' => $request->is_used ?? null,
            'active' => $request->active ?? null
        );
    }
}
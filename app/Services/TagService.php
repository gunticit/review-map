<?php

namespace App\Services;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Tag\TagRepositoryInterface;
use App\Http\Resources\TagResource;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class TagService {
    protected $projectImageRepository;



    public function __construct(TagRepositoryInterface $projectImageRepository)
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
        $data = $this->projectImageRepository->list($request);
        return $data;
    }

    public function create($request){
        $projectImage = $this->filterData($request);
        $data = $this->projectImageRepository->create($projectImage);
        return $data;
    }

    public function createDataImages($request, $project_id){
        $data = array();
        if ($request->hasFile('images')) {
            $this->projectImageRepository->deleteByKey('project_id',$project_id);
            $folder = 'uploads' . '/' . date('Y-m') . '/' . date('d') . '/' . $project_id;
            foreach ($request->file('images') as $image) {
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
}
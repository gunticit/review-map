<?php

namespace App\Services;

use App\Repositories\Tag\TagRepositoryInterface;

class TagService {
    protected $projectImageRepository;



    public function __construct(TagRepositoryInterface $projectImageRepository)
    {
        $this->projectImageRepository = $projectImageRepository;
    }

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

    private function filterData($request): array{
        $data = $request->all();
        return array(
            'name' => $data['name'] ?? null,
            'slug' => $data['slug'] ?? null,
            'subject_id' => $data['subject_id'] ?? null
        );
    }
}
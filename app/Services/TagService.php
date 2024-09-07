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

    private function filterData($request): array{
        $data = $request->all();
        return array(
            'name' => $data['name'],
            'slug' => $data['slug'],
            'subject_id' => $data['subject_id'],
        );
    }
}
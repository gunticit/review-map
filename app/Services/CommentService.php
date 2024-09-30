<?php

namespace App\Services;

use App\Jobs\GenerateCommentJob;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Comment\CommentRepositoryInterface;
use Illuminate\Validation\ValidationException;

class CommentService {
    protected $commentRepository;

    public function __construct(
        CommentRepositoryInterface $commentRepository,
    )
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * Authenticates the project with the given credentials.
     *
     * @param array $credentials The project's login credentials.
     * @return mixed|null The authenticated project if successful, null otherwise.
     * @throws ValidationException
     */

    public function list($request){
        return $this->commentRepository->list($request);
    }

    public function fullList($request){
        $projects = $this->commentRepository->list($request);
        return $projects;
    }

    public function create($request){
        $data = $this->filterData($request);
        $data_create = array();
        foreach($data['comment'] as $comment){
            $data_create[] = array(
                'project_id' => $data['project_id'],
                'comment' => $comment,
                'keyword' => $data['keyword']
            );
        }
        $data = $this->commentRepository->insert($data_create);
        return $data;
    }

    public function show($id){
        $data = $this->commentRepository->find($id);
        return $data;
    }

    public function update($request, $id){
        $project = $this->filterData($request);
        $data = $this->commentRepository->update($project, $id);
        return $data; 
    }

    public function generateComment($request){
        GenerateCommentJob::dispatch($request);
        return true;

    }

    private function filterData($request): array{
        $data = is_array($request) ? $request : $request->all();
        $keyword = '';
        $keyword .= $data['keyword'] ?? null;
        $keyword .= $data['keyword_value'] ?? null;
        return array(
            'project_id' => $data['project_id'] ?? null,
            'comment' => $data['comment'] ?? null,
            'keyword' => $keyword
        );
    }
}
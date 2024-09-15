<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Repositories\Comment\CommentRepositoryInterface;
use Illuminate\Validation\ValidationException;
use Gemini\Laravel\Facades\Gemini;

class CommentService {
    protected $projectRepository;

    public function __construct(
        CommentRepositoryInterface $projectRepository,
    )
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
        return $this->projectRepository->list($request);
    }

    public function fullList($request){
        $projects = $this->projectRepository->list($request);
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
        $data = $this->projectRepository->insert($data_create);
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

    public function generateComment($request){
        $keyword = isset($request->keyword) ? explode(',', $request->keyword): array();
        $keyword_value = isset($request->keyword_value) ? explode(',', $request->keyword_value): array();
        $common = array_intersect($keyword, $keyword_value);
        $diff1 = array_diff($keyword, $keyword_value);
        $diff2 = array_diff($keyword_value, $keyword);
        $keywords = array_merge($diff1, $diff2, $common);

        $comments = array();

        if(!empty($keywords)){
            $stream = Gemini::geminiPro()
                ->streamGenerateContent('Tạo cho tôi 5 comments cuối mỗi comment cách nhau bởi dấu | cho chủ đề khen ngợi với các từ khóa sau dành cho cửa hàng: ', implode(', ', $keywords));
            if(!empty($stream)){
                foreach ($stream as $response) {
                    $comments[] = $response->text();
                }
            }
        }
        $filteredComments = array_filter($comments, function($comment) {
            return trim($comment) !== '' && str_replace('"', '', trim($comment));
        });
        if(!empty($filteredComments)){
            $comments = explode('|', (implode('', $filteredComments)));
        }
        return $comments;

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
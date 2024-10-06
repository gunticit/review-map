<?php

namespace App\Services;

use App\Jobs\GenerateCommentJob;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Comment\CommentRepositoryInterface;
use Gemini\Laravel\Facades\Gemini;
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
        $data_create = $this->filterData($request);
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
        // GenerateCommentJob::dispatch($request);
        $keyword = isset($request->keyword) ? explode(',', $request->keyword): array();
        $keyword_value = isset($request->keyword_value) ? explode(',', $request->keyword_value): array();
        $common = array_intersect($keyword, $keyword_value);
        $diff1 = array_diff($keyword, $keyword_value);
        $diff2 = array_diff($keyword_value, $keyword);
        $keywords = array_merge($diff1, $diff2, $common);
        $comments = '';
        $sl_comment = 10;
        if(isset($request->package)){
            switch($request->package){
                case '1':
                    $sl_comment = 10;
                    break;
                case '2':
                    $sl_comment = 50;
                    break;
                case '3':
                    $sl_comment = 100;
                    break;
                default: 
                    $sl_comment = 200;
                    break;
            }
        }
        if(!empty($keywords)){
            $stream = Gemini::geminiPro()
                ->generateContent('Tạo cho tôi '.$sl_comment.' comments cuối mỗi comment cách nhau bởi dấu | cho mô tả sau "'.$request->description.'" và keyword chủ đề là: ', implode(', ', $keywords));
            if(!empty($stream)){
                foreach ($stream as $response) {
                    if(!empty($response[0]->content->parts[0]->text)){
                        $comments =  $response[0]->content->parts[0]->text;
                    }
                }
            }
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
            'keyword' => $keyword,
            'is_used' => $data['is_used'] ?? null,
        );
    }
}
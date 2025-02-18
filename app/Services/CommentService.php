<?php

namespace App\Services;

use App\Helpers\Helper;
use App\Repositories\Comment\CommentRepositoryInterface;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Log;

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

    public function create($data_create){
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

    public function updateNewComment($request, $id){
        $comment = $request->comment ?? '';
        if($comment !== ''){
            $data = $this->commentRepository->update(['comment' => $comment], $id);
            return $data;
        }
        return [];
    }

    public function generateComment($request)
    {
        try {
            DB::beginTransaction();

            $request = new Request($request);
            $keywords = array_filter(array_map('trim', explode(',', $request->keyword ?? '')));
            $description = $request->description ?? '';
            $keyword_value = is_array($request->keyword_value) 
                ? array_map('trim', $request->keyword_value) 
                : array_filter(array_map('trim', explode(',', $request->keyword_value ?? '')));

            // Xử lý danh sách từ khóa
            $keywords = !empty($keyword_value) 
                ? array_values(array_unique(array_merge($keywords, $keyword_value))) 
                : $keywords;

            // Xác định số lượng bình luận

            if (!empty($keywords)) {
                $str_keyword = implode(',', $keywords);
                

                $summary_comment = $this->commentRepository->countDataByKey('project_id', $request->project_id); 
                $project_info = resolve(ProjectService::class)->show($request->project_id);
                if(!empty($project_info->package)){
                    switch($project_info->package){
                        case 1:
                            $sl_comment = 10;
                            break;
                        case 2:
                            $sl_comment = 50;
                            break;
                        case 3:
                            $sl_comment = 100;
                            break;
                        case 4:
                            $sl_comment = 200;
                            break;
                        default: 
                            $sl_comment = 10;
                            break;
                    }
                    if(($sl_comment - $summary_comment) < 25){
                        $sl_comment = $sl_comment - $summary_comment;
                    }else{
                        $sl_comment = 25;
                    }
                }
                $this->processComments($request->project_id, $sl_comment, $description, $str_keyword, $keyword_value);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    private function processComments($projectId, $sl_comment, $description, $str_keyword, $keyword_value)
    {
        $prompt = $this->generatePrompt($sl_comment, $description, $str_keyword);
        $stream = Gemini::geminiPro()->generateContent($prompt);
        if (empty($stream->text())) {
            return false;
        }
        
        $comments = mb_convert_encoding($stream->text(), 'UTF-8', 'UTF-8');
        $commentList = array_filter(array_map(fn($c) => str_replace('-', '', trim($c)), explode('|', $comments)));
        
        $data_comment = array_map(fn($comment) => [
            'project_id' => $projectId,
            'comment' => $comment,
            'keyword' => implode(',', $keyword_value),
        ], $commentList);
        if(count($data_comment) > $sl_comment){
            $data_comment = array_slice($data_comment, 0, $sl_comment);
        }
        return $this->create($data_comment);
        
    }

    public function generatePrompt($sl_comment, $description, $str_keyword)
    {
        $prompt = "Tạo $sl_comment bình luận, mỗi bình luận không quá 120 ký tự, liên quan đến";
        if (!empty($description)) {
            $prompt .= " mô tả '{$description}' và";
        }
        if (!empty($str_keyword)) {
            $prompt .= " chủ đề từ khóa: '($str_keyword)', hãy dùng ít nhất 1 từ khóa và nhiều nhất 2 từ khóa trong mỗi comment và các comment không được tạo trùng nhau.";
        }
        $prompt .= " Bình luận không đánh số, ngăn cách bởi ký tự '|', đảm bảo đủ $sl_comment bình luận.";
        
        if ($extraContent = Helper::getSetting('setting_ai_content')) {
            $prompt .= " Ngoài ra: " . $extraContent;
        }
        return $prompt;
    }
    
    public function generateCommentBySample($request){
        $keyword = isset($request->keyword) ? $request->keyword: '';
        $sample = isset($request->comment_sample) ? $request->comment_sample : '';
        $description = isset($request->description) ? $request->description : '';
        $comments = '';
        if(!empty($keyword) || !empty($sample)){
            $prompt = 'Tạo cho tôi 1 bình luận tương tự '.$sample.' và nội dung liên quan đến mô tả "'.$description.'" và keyword chủ đề là: '. $keyword . ', và bình luận không quá 120 ký tự.';
            if(!empty(Helper::getSetting('setting_ai_content'))){
                $prompt .= '. '.Helper::getSetting('setting_ai_content');
            }
            $stream = Gemini::geminiPro()->generateContent($prompt);
            if(!empty($stream->text())){
                $comments = $stream->text();
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
            'is_used' => $data['is_used'] ?? 0,
        );
    }

    public function deleteByKey($key, $request){
        return $this->commentRepository->deleteByKey($key, $request);
    }
    
    public function countDataByKey($column, $value){
        return $this->commentRepository->countDataByKey($column, $value);
    }
}
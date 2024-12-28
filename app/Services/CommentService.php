<?php

namespace App\Services;

use App\Helpers\Helper;
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

    public function updateNewComment($request, $id){
        $comment = $request->comment ?? '';
        if($comment !== ''){
            $data = $this->commentRepository->update(['comment' => $comment], $id);
            return $data;
        }
        return [];
    }

    public function generateComment($request){
        // GenerateCommentJob::dispatch($request);
        $keyword = isset($request->keyword) ? explode(',', $request->keyword): array();
        $description = isset($request->description) ? $request->description : '';
        if(!empty($request->keyword_value) && !empty($keyword)){
            $keyword_value = isset($request->keyword_value) ? explode(',', $request->keyword_value): array();
            $common = array_intersect($keyword, $keyword_value);
            $diff1 = array_diff($keyword, $keyword_value);
            $diff2 = array_diff($keyword_value, $keyword);
            $keywords = array_merge($diff1, $diff2, $common);
        }
        $comments = '';
        $sl_comment = 10;
        if(isset($request->package)){
            switch((int)$request->package){
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
        }
        if(!empty($keywords)){
            $str_keyword = count($keywords) > 0 ? implode(', ', $keywords) : '';
            if($sl_comment < 100){
                $prompt = "Tạo cho tôi ".$sl_comment." bình luận, với mỗi bình luận cảm nhận ngắn không quá 120 ký tự với nội dung liên quan đến";
                if(!empty($description)){
                    $prompt .= " mô tả '".$description."' và";
                }
                if(!empty($str_keyword)){
                    $prompt .= " keyword chủ đề là: '(". $str_keyword .")'.";
                }
                $prompt .= " Yêu cầu bình luận tạo ra không đánh dấu số thứ tự và các bình luận được ngăn cách bởi ký tự | để phân biệt, và đủ số lượng bình luận là: ".$sl_comment." bình luận.";
                if(!empty(Helper::getSetting('setting_ai_content'))){
                    $prompt .= ' Ngoài ra: '.Helper::getSetting('setting_ai_content');
                }
                $stream = Gemini::geminiPro()
                    ->generateContent($prompt);
                if(!empty($stream->text())){
                    $comments = $stream->text();
                }
            }else if($sl_comment == 100){
                for($i = 1; $i <= 2; $i++){
                    $prompt = "Tạo cho tôi 50 bình luận, với mỗi bình luận cảm nhận ngắn không quá 120 ký tự với nội dung liên quan đến";
                    if(!empty($description)){
                        $prompt .= " mô tả '".$description."' và";
                    }
                    if(!empty($str_keyword)){
                        $prompt .= " keyword chủ đề là: '(". $str_keyword .")'.";
                    }
                    $prompt .= " Yêu cầu bình luận tạo ra không đánh dấu số thứ tự và các bình luận được ngăn cách bởi ký tự | để phân biệt, và đủ số lượng bình luận là: ".$sl_comment." bình luận.";
                    if(!empty(Helper::getSetting('setting_ai_content'))){
                        $prompt .= ' Ngoài ra: '.Helper::getSetting('setting_ai_content');
                    }
                    $stream = Gemini::geminiPro()
                        ->generateContent($prompt);
                    if(!empty($stream->text())){
                        $comments .= $stream->text();
                    }
                }
            }
        }
        return $comments;
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
}
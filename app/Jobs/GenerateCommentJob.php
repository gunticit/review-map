<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Gemini\Laravel\Facades\Gemini;

class GenerateCommentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $request;
    /**
     * Create a new job instance.
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $keyword = isset($request->keyword) ? explode(',', $request->keyword): array();
        $keyword_value = isset($request->keyword_value) ? explode(',', $request->keyword_value): array();
        $description = isset($request->description) ? $request->description : '';
        $common = array_intersect($keyword, $keyword_value);
        $diff1 = array_diff($keyword, $keyword_value);
        $diff2 = array_diff($keyword_value, $keyword);
        $keywords = array_merge($diff1, $diff2, $common);
        $comments = array();
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
                ->generateContent('Tạo cho tôi '.$sl_comment.' bình luận không đánh số thứ tự mỗi ở mỗi bình luận, cuối mỗi bình luận cách nhau bởi dấu | cho mô tả sau "'.$description.'" và keyword chủ đề là: ', implode(', ', $keywords) . ', và mỗi bình luận không quá 120 ký tự.');
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
    }
}

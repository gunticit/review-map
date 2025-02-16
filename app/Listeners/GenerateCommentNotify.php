<?php

namespace App\Listeners;

use App\Events\GenerateCommentSuccess;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Session;
use Log;

class GenerateCommentNotify implements ShouldQueue
{
    use InteractsWithQueue;

    protected $commentService;

    public function __construct(\App\Services\CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function handle(GenerateCommentSuccess $event)
    {
        $event_request = $event->request;
        $project_id = $event->project_id;
        $keyword_data = $event->keyword_data;
        $sl_comment = $event->sl_comment;
        $event_request['project_id'] = $project_id;
        $comments = explode('|', $this->commentService->generateComment($event_request));

        if (empty($comments)) {
            Session::flash('error', 'Không thể tạo câu hỏi cho dự án, vui lòng chỉnh sửa lại nội dung và tạo lại!');
            return;
        }

        $data_comment = array_map(function ($i) use ($comments, $project_id, $keyword_data) {
            return [
                'project_id' => $project_id,
                'comment' => isset($comments[$i - 1]) ? str_replace('-', '', trim($comments[$i - 1])) : '',
                'keyword' => implode(',', $keyword_data)
            ];
        }, range(1, $sl_comment));

        $this->commentService->create($data_comment);

        Log::info("Project {$project_id} generated {$sl_comment} comments successfully.");
    }
}

<?php

namespace App\Http\Controllers;

use App\Services\HistoryService;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    protected $historyService; 
    public function __construct(HistoryService $historyService){
        $this->historyService = $historyService;
    }

    public function index(Request $request){
        $histories = $this->historyService->list($request);
        $data = array();
        if(!empty($histories)){
            foreach($histories as $history){
                $content = isset($history['content']) ? json_decode($history['content']) : array();
                $data['histories'][] = array(
                    'title' => $content->title ?? '',
                    'content' => $content->content ?? '',
                    'user_id' => $content->user_id ?? '',
                    'created_at' => $history['created_at']
                );
            }
        }
        return view('pages.history', [
            'histories' => $histories->setCollection(collect($data))
        ]);
    }
}

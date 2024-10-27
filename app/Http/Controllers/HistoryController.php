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
        $data['histories'] = $histories;
        $data['filter'] = $request->all();
        return view('pages.history', $data);
    }

}

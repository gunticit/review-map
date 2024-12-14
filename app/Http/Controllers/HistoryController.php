<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Services\HistoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    protected $historyService; 
    public function __construct(HistoryService $historyService){
        $this->historyService = $historyService;
    }

    public function index(Request $request){
        $request = $request->merge(['user_id' => Auth::user()->id]);
        $histories = $this->historyService->list($request);
        $data['histories'] = $histories;
        $data['filter'] = $request->all();
        return view('pages.history', $data);
    }

}

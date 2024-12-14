<?php

namespace App\Http\Controllers;

use App\Services\CensorshipHistoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CensorshipHistoryController extends Controller
{
    protected $censorshipHistoryService;
    public function __construct(CensorshipHistoryService $censorshipHistoryService){
        $this->censorshipHistoryService = $censorshipHistoryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $this->censorshipHistoryService->list($request);
        return view('pages.admin.censorship-history.list',[
            'censorship_histories' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function createJson(Request $request){
        $validation = Validator::make($request->all(), [
            'approver_id' => 'required',
            'mission_id' => 'required',
            'partner_id' => 'required',
            'status' => 'required'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'title' => 'Tạo lịch sử kiểm duyệt',
                'data' => null,
                'message' => $validation->errors()->first(),
                'status' => false
            ]);
        }
        
        $data = $this->censorshipHistoryService->create($request);
        return response()->json([
            'title' => 'Tạo lịch sử kiểm duyệt',
            'data' => $data,
            'message' => 'Tạo thành công',
            'status' => true
        ]);
    }
}

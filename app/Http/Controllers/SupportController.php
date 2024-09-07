<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupportRequest;
use App\Http\Resources\SupportResource;
use App\Services\ProjectService;
use App\Services\SupportService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SupportController extends Controller
{
    protected $supportService, $projectService;
    public function __construct(
        SupportService $supportService,
        ProjectService $projectService
    ){
        $this->supportService = $supportService;
        $this->projectService = $projectService;
    }
    public function index(Request $request){
        $supports =  $this->supportService->list($request);
        $data = SupportResource::collection($supports)->resource;
        return view('pages.customer.support.list', [
            'supports' => $data
        ]);
    }
    public function edit(){
        return view('pages.customer.support.edit');
    }
    public function create(Request $request){
        $projects = $this->projectService->list($request);
        return view('pages.customer.support.create',[
            'projects' => $projects,
        ]);
    }
    public function store(SupportRequest $request){
        try{
            $data = $this->supportService->create($request);
            Session::flash('success', 'Khởi tạo yêu cầu hỗ trợ thành công');
            return redirect()->back()->withInput();
        }catch(Exception $e){
            Session::flash('error', 'Không thêm được yêu cầu hỗ trợ');
        }
    }
    public function update(SupportRequest $request){
        try{

            Session::flash('success', 'Khởi tạo dự án thành công');
            return redirect()->route('project.list');
        }catch(Exception $e){
            Session::flash('error', 'Không thêm được yêu cầu hỗ trợ');
            return redirect()->back()->withInput();
        }
    }
}

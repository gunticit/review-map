<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupportRequest;
use App\Http\Resources\SupportResource;
use App\Models\Department;
use App\Services\CategoryService;
use App\Services\ProjectService;
use App\Services\SupportService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SupportController extends Controller
{
    protected $supportService, $projectService, $categoryService;
    public function __construct(
        SupportService $supportService,
        ProjectService $projectService,
        CategoryService $categoryService
    ){
        $this->supportService = $supportService;
        $this->projectService = $projectService;
        $this->categoryService = $categoryService;
    }
    public function index(Request $request){
        $supports =  $this->supportService->list($request);
        $projects = $this->projectService->list($request);
        $data = SupportResource::collection($supports)->resource;
        return view('pages.customer.support.list', [
            'supports' => $data,
            'projects' => $projects,
        ]);
    }
    public function edit(){
        return view('pages.customer.support.edit');
    }
    public function create(Request $request){
        $request->merge(['user_id' => auth()->id()]);
        $projects = $this->projectService->fullList($request);
        $categories = $this->categoryService->fullList($request);
        $departments = Department::all();
        return view('pages.customer.support.create',[
            'projects' => $projects,
            'departments' => $departments,
            'heading_title' => 'Tạo yêu cầu hỗ trợ'
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

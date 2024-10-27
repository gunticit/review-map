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
use App\Events\NotificationAdminEvent;
use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $supports =  $this->supportService->listCreateByUser($request);
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
        $projects = Project::where('created_by', auth()->id())->get();
        $categories = $this->categoryService->fullList($request);
        $departments = Department::all();
        return view('pages.customer.support.create',[
            'projects' => $projects,
            'departments' => $departments,
            'categories' => $categories,
            'heading_title' => 'Tạo yêu cầu hỗ trợ'
        ]);
    }
    public function store(SupportRequest $request){
        try{
            DB::beginTransaction();
            $data = $this->supportService->create($request);
            $userIds = User::where('department_id', $request->department_id)->get()->pluck('id')->toArray();
            foreach($userIds as $userId) {
                $dataNotification = [
                    'user_id' => $userId,
                    'title' => $data->title,
                    'content' => $data->content,
                    'support_id' => $data->id,
                    'created_at' => $data->created_at
                ];
                $noti = Notification::create($dataNotification);
                event(new NotificationAdminEvent($noti->toArray(), $userId));
            }
            DB::commit();
            Session::flash('success', 'Khởi tạo yêu cầu hỗ trợ thành công');
            return redirect()->back()->withInput();
        }catch(Exception $e){
            DB::rollBack();
            Session::flash('error', 'Không thêm được yêu cầu hỗ trợ');
            return redirect()->back()->withInput();
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

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use App\Models\Support;
use App\Http\Requests\AdminSupportRequest;


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
        $supports =  $this->supportService->listOfDepartment($request);
        $projects = $this->projectService->list($request);
        $data = SupportResource::collection($supports)->resource;
        return view('pages.admin.support.list', [
            'supports' => $data,
        ]);
    }
    public function edit($id){
        $data = Support::where('id', $id)->with('user')->firstOrFail();
        $reply = Support::where('reply_id', $id)->with('user')->orderBy('created_at', 'asc')->get();
        return view('pages.admin.support.detail', [
            'support' => $data,
            'replies' => $reply
        ]);
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
    public function store(AdminSupportRequest $request, $id){
        try{
            DB::beginTransaction();
            $support = Support::find($id);
            $support->update(['status' => 3]);
            $request = $request->merge(
                [
                    'reply_id' => $id,
                    'title' => $support->title,
                    'support_code' => $support->support_code
            ]);
            $data = $this->supportService->create($request);
            $dataNotification = [
                'user_id' => $support->created_by,
                'title' => $data->title,
                'content' => $data->content,
                'support_id' => $data->id,
                'created_at' => $data->created_at
            ];
            $noti = Notification::create($dataNotification);
            event(new NotificationAdminEvent($noti->toArray(), $support->created_by));
            DB::commit();
            Session::flash('success', 'Khởi tạo yêu cầu hỗ trợ thành công');
            return redirect()->back()->withInput();
        }catch(Exception $e){
            DB::rollBack();
            Session::flash('error', 'Không thêm được yêu cầu hỗ trợ');
            return redirect()->back()->withInput();
        }
    }
}

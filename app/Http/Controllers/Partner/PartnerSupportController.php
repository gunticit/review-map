<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupportRequest;
use App\Http\Resources\SupportResource;
use App\Models\Department;
use App\Models\Project;
use App\Services\CategoryService;
use App\Services\ProjectService;
use App\Services\SupportService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Events\NotificationAdminEvent;
use App\Models\Role;
use App\Models\User;
use App\Models\Notification;

class PartnerSupportController extends Controller
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
        return view('pages.partner.support.list', [
            'supports' => $supports,
            'projects' => $projects,
        ]);
    }
    public function edit(){
        return view('pages.partner.support.edit');
    }
    public function create(Request $request){
        $request->merge(['user_id' => auth()->id()]);
        $projects = Project::leftJoin('missions', 'projects.id', '=', 'missions.project_id')->where('missions.user_id', $request->user_id)->select('projects.*')->distinct('projects.id')->get();
        $categories = $this->categoryService->fullList($request);
        $departments = Department::all();
        return view('pages.partner.support.create',[
            'departments' => $departments,
            'heading_title' => 'Tạo yêu cầu hỗ trợ'
        ]);
    }
    public function store(SupportRequest $request){
        try{
            \DB::beginTransaction();
            $data = $this->supportService->create($request);
            event(new NotificationAdminEvent($data->toArray(), Role::ADMIN_ROLE));
            $userIds = User::where('department_id', $request->department_id)->get()->pluck('id')->toArray();
            $dataNotification = [];
            foreach($userIds as $userId) {
                $dataNotification[] = [
                    'user_id' => $userId,
                    'title' => $data->title,
                    'content' => $data->content,
                    'support_id' => $data->id,
                    'created_at' => $data->created_at
                ];
            }
            Notification::insert($dataNotification);
            \DB::commit();
            Session::flash('success', 'Khởi tạo yêu cầu hỗ trợ thành công');
            return redirect()->back()->withInput();
        }catch(Exception $e){
            \DB::rollBack();
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

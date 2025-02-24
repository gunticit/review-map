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
use App\Models\Support;
use App\Services\SupportMessageService;
use Illuminate\Support\Facades\DB;

class SupportController extends Controller
{
    protected $supportService, $projectService, $categoryService, $supportMessageService;
    public function __construct(
        SupportService $supportService,
        ProjectService $projectService,
        CategoryService $categoryService,
        SupportMessageService $supportMessageService
    ){
        $this->supportService = $supportService;
        $this->projectService = $projectService;
        $this->categoryService = $categoryService;
        $this->supportMessageService = $supportMessageService;
    }
    public function index(Request $request){
        $user = auth()->user();
        if($user->hasRole(Role::ADMIN_ROLE)){
            $request->merge([
                'department_id' => $user->department_id
            ]);
            $supports = $this->supportService->list($request);
        }else{
            $supports =  $this->supportService->listCreateByUser($request);
        }
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
    public function detail($id, Request $request){
        $support_info = $this->supportService->reply($id, $request);
        $data['support_info'] = $support_info;
        $data['support_id'] = $id;
        $data['departments'] = Department::all();
        $data['projects'] = Project::all();
        return view('pages.customer.support.detail', $data);
    }

    public function reply($id, Request $request){
        $support_info = $this->supportService->reply($id, $request);
        $data['support_info'] = $support_info;
        $data['support_id'] = $id;
        $data['departments'] = Department::all();
        $data['projects'] = Project::all();
        return view('pages.customer.support.reply', $data);
    }

    public function updateReply($id,Request $request){
        $support = Support::find($id);
        $receive_id = $support->send_id; // Mặc định người đặt câu hỏi sẽ là người nhận câu trả lời
        $type = 'question';
        // Nếu người đang đăng nhập khác người đặt câu hỏi => người trả lời => người đặt câu hỏi là người nhận receive_id = người đặt câu hỏi
        if($support->send_id != auth()->id()){
            $type = 'answer';
        }else{
            if(!empty($support->messages)){
                foreach($support->messages as $message){
                    if($message->send_id == auth()->id()){
                        $receive_id = $message->receive_id;
                        break;
                    }else{
                        $receive_id = $message->send_id;
                        break;
                    }
                }
            }
        }
        $filepath = $request->file('filepath');
        if($filepath){
            $request->merge([
                'project_id' => $support->project_id
            ]);
            $file_path = $this->uploadImage($request);
            $request->merge([
                'file_path' => $file_path
            ]);
        }
        $request->merge([
            'receive_id' => $receive_id,
            'type' => $type,
            'support_id' => $id,
            'send_id' => auth()->id()
        ]);
        $data = $this->supportMessageService->create($request);
        if(!$data){
            return redirect()->back()->with('error', 'Lỗi không thể hỗ trợ! Vui lòng thử lại sau hoặc báo IT');
        }
        $request = $request->merge(['status' => 1]);
        $this->supportService->update($request, $id);
        return redirect()->back()->with('success', 'Gửi đi thành công!');
    }

    public function uploadImage($request){
        $path = '';
        $project_id = $request->project_id ?? 'undefined'; 
        if ($request->hasFile('filepath')) {
            $folder = 'uploads' . '/supports/' . date('Y-m') . '/' . date('d') . '/' . $project_id;
            $image = $request->file('filepath');
            $extension = $image->getClientOriginalExtension();
            $fileName = 'support-'.$project_id.'-'.date('Y-m-d') . time() . '.' . $extension;
            $path = $image->storeAs($folder, $fileName, 'public');
        }
        return $path;
    }

    public function closeSupport($id){
        $support = Support::find($id);
        $support->status = 4;
        $support->save();
        if(auth()->user()->hasRole(Role::ADMIN_ROLE)){
            return redirect()->route('admin.support')->with('success', 'Đã đóng hỗ trợ '.$support->title.' thành công!');
        }else if(auth()->user()->hasRole(Role::CUSTOMER_ROLE)){
            return redirect()->route('support.customer');
        } else if(auth()->user()->hasRole(Role::PARTNER_ROLE)){
            return redirect()->route('partner.support');
        }
    }
    
    public function view_document($url){
        $data = [
            'doc_url' => ''
        ];
        return view('support.document', $data);
    }
}

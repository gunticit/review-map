<?php

namespace App\Http\Controllers;

use App\Exceptions\ProcessException;
use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;
use App\Services\CommentService;
use App\Services\HistoryService;
use App\Services\ProjectService;
use App\Services\ProjectImageService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProjectController extends Controller
{
    protected $projectService, $projectImageService, $historyService, $commentService;
    public function __construct(
        ProjectService $projectService, 
        ProjectImageService $projectImageService, 
        CommentService $commentService, 
        HistoryService $historyService
    ){
        $this->projectService = $projectService;
        $this->projectImageService = $projectImageService;
        $this->historyService = $historyService;
        $this->commentService = $commentService;
    }
    public function index(Request $request){
        $data = $this->projectService->list($request);
        return view('pages.customer.projects.list',[
            'projects' => $data['projects'] ?? [],
            'total' => $data['total'] ?? 0,
            'working' => $data['working'] ?? 0,
            'stopped' => $data['stopped'] ?? 0,
        ]);
    }

    public function create(Request $request){
        $data = array(
            'latitude' => '10.8299',
            'longitude' => '106.68029'
        );
        return view('pages.customer.projects.create',$data);
    }

    public function store(ProjectRequest $request){
        try{
            $data = $this->projectService->create($request);
            if($data){
                $request->request->add(['project_id' => $data->id]);
                $request->request->add(['noJson' => true]);
                $comment = $this->generateComment($request);
                if(!empty($comment)){
                    $request->request->add(['comment' => $comment]);
                    $this->commentService->create($request);
                }
                if ($request->has('has_image') && $request->has_image == 1) {
                    $this->projectImageService->createDataImages($request, $data->id);
                }
                $content_history = [
                    'title' => 'Dự án khởi tạo thành công',
                    'content' => 'Dự án khởi tạo thành công vào lúc: ' . $data['created_at'],
                    'status' => 1,
                    'user_id' => Auth::user()->id
                ];
                $this->historyService->create([
                    'content' => json_encode($content_history),
                    'user_id' => Auth::user()->id
                ]);
                Session::flash('success', 'Khởi tạo dự án thành công');
                return redirect()->route('project.list');
            }
            $content_history = [
                'title' => 'Dự án tạo không thành công',
                'content' => 'Dự án tạo không thành công vào lúc: ' . $data['created_at'],
                'status' => 0,
                'user_id' => Auth::user()->id
            ];
            $this->historyService->create([
                'content' => json_encode($content_history),
                'user_id' => Auth::user()->id
            ]);
            Session::flash('error', 'Tạo dự án không thành công');
            return redirect()->back()->withInput();
        }catch(\Exception $e){
            throw new ProcessException($e);
        }
    }

    public function edit($id){
        $data = $this->projectService->show($id);
        return view('pages.customer.projects.edit',[
            'project' => $data
        ]);
    }

    public function update(ProjectRequest $request, $id){
        try{
            $data = $this->projectService->update($request, $id);
            if($data){
                if ($request->has('has_image') && $request->has_image == 1) {
                    $this->projectImageService->createDataImages($request, $data->id);
                }
                Session::flash('success', 'Cập nhật dự án thành công');
                return redirect()->route('project.list');
            }
            Session::flash('error', 'Không thể cập nhật dự án');
            return redirect()->back()->withInput();
        }catch(\Exception $e){
            throw new ProcessException($e);
        }
    }

    public function updateStatus(Request $request, $id){
        return redirect()->back();
    }

    public function generateComment($request){
        $comments = $this->commentService->generateComment($request);
        if(isset($request->noJson)){
            return $comments;
        }
        return response()->json($comments);
    }
    
    public function wrongImages($id){
        $data = $this->projectService->wrongImages($id);
        return response()->json([
            'data' => $data
        ]);
    }
}

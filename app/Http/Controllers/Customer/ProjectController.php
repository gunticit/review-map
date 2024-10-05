<?php

namespace App\Http\Controllers\Customer;

use App\Exceptions\ProcessException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Services\CommentService;
use App\Services\HistoryService;
use App\Services\ProjectService;
use App\Services\ProjectImageService;
use Illuminate\Pagination\LengthAwarePaginator;
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
            $project_id = $data->id;
            $keyword = isset($request->keyword) ? explode(',', $request->keyword): array();
            $keyword_value = isset($request->keyword_value) ? explode(',', $request->keyword_value): array();
            $keyword_array = array_merge($keyword, $keyword_value);
            $unique_keyword_array = array_unique($keyword_array);
            $keyword_data = array_filter($unique_keyword_array, function($value) {
                return $value !== null && $value !== "";
            });
            if($data && $project_id){
                $request->request->add(['project_id' => $project_id]);
                $request->request->add(['noJson' => true]);
                $comments = $this->commentService->generateComment($request);
                if(!empty($comments)){
                    $comments = explode('|', $comments);
                    foreach($comments as $comment){
                        if($comment != ''){
                            $data_comment = array(
                                'project_id' => $project_id,
                                'comment' => $comment,
                                'keyword' => implode(',', $keyword_data)
                            );
                        }
                        $this->commentService->create($data_comment);
                    }
                }
                if ($request->has('has_image') && $request->has_image == 1) {
                    $this->projectImageService->createDataImages($request, $project_id);
                }
                $content_history = [
                    'title' => 'Dự án khởi tạo thành công',
                    'content' => 'Dự án khởi tạo thành công vào lúc: ' . $data['created_at'],
                    'status' => 6, // Chờ admin duyệt
                    'user_id' => Auth::user()->id
                ];
                $this->historyService->create([
                    'content' => json_encode($content_history),
                    'user_id' => Auth::user()->id
                ]);
                Session::flash('success', 'Khởi tạo dự án thành công');
                return redirect()->route('page.order.project', ['id' => $project_id])
                ->with('success', 'Khởi tạo dự án thành công');
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
        try{
            $this->projectService->updateStatus($request, $id);
            return response()->json([
                'status' => 'success',
                'data' => $request->status,
                'message' => 'Cập nhật thành công'
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
    
    public function wrongImages($id){
        $data = $this->projectService->wrongImages($id);
        return response()->json([
            'data' => $data
        ]);
    }

    public function updateOrderProject(Request $request){
        $data = $this->projectService->updateOrderProject($request->project_id);
        return response()->json([
            'data' => $data
        ]);
    }

    public function pageOrderProject($project_id, Request $request){
        $project_comments = $this->projectService->findWithComments($project_id, $request);
        $projects = array();
        if($project_comments && $project_comments->comments){
            $comments = $project_comments->comments;
            $perPage = 15;
            $currentPage = isset($request->page) ? $request->page  : LengthAwarePaginator::resolveCurrentPage();
            $currentComments = $comments->slice(($currentPage - 1) * $perPage, $perPage)->values();
            $paginatedComments = new LengthAwarePaginator(
                $currentComments,
                $comments->count(),
                $perPage,
                $currentPage,
                ['path' => LengthAwarePaginator::resolveCurrentPath()]
            );
        }
        return view('pages.customer.projects.order', [
            'projects' => $paginatedComments,
            'project_info' => $project_comments
        ]);
    }

    public function destroyByIds(Request $request){
        try{
            $data = $this->projectService->destroyByIds($request);
            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
        } catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}

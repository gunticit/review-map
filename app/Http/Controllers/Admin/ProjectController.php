<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Services\ProjectService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    protected $projectService;
    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $projects = $this->projectService->list($request);
        $projects = ProjectResource::collection($projects)->resource;
        return view('pages.admin.project.list', [
            'projects' => $projects,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = array();
        return view('pages.admin.project.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Xác thực dữ liệu
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'parent' => 'nullable|exists:projects,id',
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Giới hạn kích thước ảnh 2MB
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
    
            // Xử lý hình ảnh nếu có
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('projects', 'public'); // Lưu hình ảnh vào thư mục 'projects' trong storage
                $request->merge(['image_path' => $imagePath]); // Thêm đường dẫn hình ảnh vào request
            }
    
            // Tạo mới dự án
            $this->projectService->create($request);
    
            return redirect()->route('project.index')->with('success', 'Thêm dự án thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->projectService->show($id);
        return view('pages.admin.project.show', $data);
    }

    public function showJson(string $id){
        $data = $this->projectService->show($id);
        return response()->json([
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('pages.admin.project.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $this->projectService->update($request, $id);
            return redirect()->route('project.index')->with('success', 'Cập nhật Danh mục thành công');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $this->projectService->delete($id);
            return redirect()->route('project.index')->with('success', 'Xoá Danh mục thành công');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function projectsList(Request $request){
        try{
            $data = $this->projectService->fullList($request);
            return response()->json([
                'title' => 'Load data Danh mục',
                'data' => $data
            ]);
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function wrongImage($id){
        try{
            $data = $this->projectService->wrongImage($id);
            return response()->json([
                'data' => $data
            ]);
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroyProjectById(string $id)
    {
        try{
            $this->projectService->delete($id);
            return response()->json([
                'status' => true,
                'id' => $id,
                'message' => 'Xoá Danh mục thành công'
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'id' => $id,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function updateStatus(Request $request, $id){
        try{
            $validator = Validator::make($request->all(), [
                'status' => 'required|in:1,2,3,4'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'messaage' => $validator->errors()->all()
                ]);
            }
            $data = $this->projectService->updateStatus($request, $id);
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật trạng thái thành công',
                'data' => $data
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}

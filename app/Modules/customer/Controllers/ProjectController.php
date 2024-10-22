<?php

namespace App\Http\Controllers;

use App\Exceptions\ProcessException;
use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;
use App\Services\ProjectService;
use App\Services\ProjectImageService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Validate;

class ProjectController extends Controller
{
    protected $projectService, $projectImageService;
    public function __construct(ProjectService $projectService, ProjectImageService $projectImageService){
        $this->projectService = $projectService;
        $this->projectImageService = $projectImageService;
    }
    public function index(Request $request){
        $data = $this->projectService->list($request);
        return view('pages.projects.list',[
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
        return view('pages.projects.create',$data);
    }

    public function store(ProjectRequest $request){
        try{
            $data = $this->projectService->create($request);
            if($data){
                if ($request->has('has_image') && $request->has_image == 1) {
                    $this->projectImageService->createDataImages($request, $data->id);
                }
                Session::flash('success', 'Khởi tạo dự án thành công');
                DB::commit();
                return redirect()->route('project.list');
            }
            Session::flash('error', 'Tạo dự án không thành công');
            return redirect()->back()->withInput();
        }catch(\Exception $e){
            throw new ProcessException($e);
        }
    }
}

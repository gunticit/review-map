<?php

namespace App\Http\Controllers;

use App\Exceptions\ProcessException;
use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;
use App\Services\ProjectService;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Validate;

class ProjectController extends Controller
{
    protected $projectService;
    public function __construct(ProjectService $projectService){
        $this->projectService = $projectService;
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
                Session::flash('success', 'Khởi tạo dự án thành công');
                return redirect()->route('project.list');
            }
            Session::flash('error', 'Tạo dự án không thành công');
            return redirect()->back()->withInput();
        }catch(\Exception $e){
            throw new ProcessException($e);
        }
    }
}

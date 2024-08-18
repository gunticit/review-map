<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;
use App\Services\ProjectService;
use Livewire\Attributes\Validate;

class ProjectController extends Controller
{
    protected $projectService;
    public function __construct(ProjectService $projectService){
        $this->projectService = $projectService;
    }
    public function index(){
        return view('pages.projects.list');
    }

    public function create(Request $request){
        return view('pages.projects.create');
    }

    public function store(ProjectRequest $request){
        try{
            dd($request);
            $data = $request->all();
            $check = $this->projectService->create($data);
            dd($check);
        }catch(\Exception $e){
            dd($e);
        }
    }
}

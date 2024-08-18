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
        $data = array(
            'latitude' => '10.8299',
            'longitude' => '106.68029'
        );
        return view('pages.projects.create',$data);
    }

    public function store(Request $request){
        $data = $this->projectService->create($request);
        dd($data);
    }
}

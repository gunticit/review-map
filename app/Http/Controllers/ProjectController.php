<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;

class ProjectController extends Controller
{
    public function index(){
        return view('pages.projects.list');
    }

    public function create(ProjectRequest $request){
        if($request->isMethod('post')){
            $data = $request->all();
            return redirect()->back();
        }
        return view('pages.projects.create');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ApproveApplicationController extends Controller
{
    public function index(){
        $data = array();
        $projects = Project::all();
        if(!empty($projects)){
            foreach($projects as $project){
                $data['projects'][] = array(
                    'id' => $project['id'],
                    'name' => $project['name'],
                    'description' => substr($project['description'], 0, 200),
                    'keyword' => $project['keyword'],
                    'url' => route('project.edit', ['id' => $project['id']]),
                    'status' => $project['status'],
                    'id_confirm' => $project['id_confirm'],
                    'id_cancel' => $project['id_cancel']
                );
            }
        }
        return view('pages.admin.approve-application.index', $data);
    }
}

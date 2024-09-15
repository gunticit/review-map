<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Carbon\Carbon;


class ApproveApplicationController extends Controller
{
    public function index(){
        $data = array();
        $projects = Project::all();
        $now = Carbon::now();
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
                    'id_cancel' => $project['id_cancel'],
                    'created_at' => $project['createdAt']->diffInMonths($now) < 1 ? 
                    Carbon::parse($project['created_at'])->
                    diffForHumans():$project['createdAt']->format('d/m/Y H:i'),
                );
            }
        }
        return view('pages.admin.approve-application.index', $data);
    }
}

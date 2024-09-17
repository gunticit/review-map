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
                $createdAt = $project['created_at'] ?? null;
                if ($createdAt) {
                    $created_at = $createdAt->diffInMonths($now) < 1 ? Carbon::parse($createdAt)->locale(app()->getLocale())->diffForHumans():$createdAt->format('d/m/Y H:i');
                } else {
                    $created_at = null;
                }
                $data['projects'][] = array(
                    'id' => $project['id'],
                    'name' => $project['name'],
                    'description' => substr($project['description'], 0, 200),
                    'keyword' => $project['keyword'],
                    'url' => route('project.edit', ['id' => $project['id']]),
                    'status' => $project['status'],
                    'id_confirm' => $project['id_confirm'],
                    'id_cancel' => $project['id_cancel'],
                    'created_at' => $created_at,
                );
            }
        }
        return view('pages.admin.approve-application.index', $data);
    }
}

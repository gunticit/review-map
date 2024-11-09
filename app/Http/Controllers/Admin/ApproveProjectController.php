<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Services\ApiGoogleService;
use Carbon\Carbon;


class ApproveProjectController extends Controller
{
    public function index(){
        $data = array();
        $projects = Project::leftJoin('comments', 'projects.id', '=', 'comments.project_id')
        ->rightJoin('missions', 'comments.id', '=', 'missions.comment_id')
        ->leftJoin('image_projects', 'missions.image_id', '=', 'image_projects.id')
        ->select(
            'projects.*',
            'projects.id as project_id',
            'comments.comment',
            'missions.*',
            'missions.id as mission_id',
            'image_projects.image_url as image_url'
        )
        ->get();
        $now = Carbon::now();
        if(!empty($projects)){
            foreach($projects as $project){
                $createdAt = $project['created_at'] ?? null;

                $googleComments = app(ApiGoogleService::class)->getPlaceDetails($project['place_id']);
                if ($createdAt) {
                    $created_at = $createdAt->diffInMonths($now) < 1 ? Carbon::parse($createdAt)->locale(app()->getLocale())->diffForHumans():$createdAt->format('d/m/Y H:i');
                } else {
                    $created_at = null;
                }
                $data['projects'][] = array(
                    'id' => $project['id'],
                    'project_id' => $project['project_id'],
                    'image_id' => $project['image_id'],
                    'name' => $project['name'],
                    'description' => substr($project['description'], 0, 200),
                    'keyword' => $project['keyword'],
                    'url' => 'project/' . $project['id'],
                    'status' => $project['status'],
                    'id_confirm' => $project['id_confirm'],
                    'place_id' => $project['place_id'],
                    'id_cancel' => $project['id_cancel'],
                    'created_at' => $created_at,
                );
            }
        }
        $data['status_complete'] = Project::COMPLETED_PROJECT;

        return view('pages.admin.approve-project.index', $data);
    }
}

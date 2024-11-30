<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Services\ApiGoogleService;
use App\Services\ProjectService;
use Carbon\Carbon;


class ApproveProjectController extends Controller
{
    public $projectService;
    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }
    public function index(Request $request){
        $data = array();
        $request = $request->merge([
            'status' => 2
        ]);
        $projects = $this->projectService->fullList($request);
        $now = Carbon::now();
        if(!empty($projects)){
            foreach($projects as $project){
                $createdAt = $project['created_at'] ?? null;

                //$googleComments = app(ApiGoogleService::class)->getPlaceDetails($project['place_id']);
                if ($createdAt) {
                    $created_at = $createdAt->diffInMonths($now) < 1 ? Carbon::parse($createdAt)->locale(app()->getLocale())->diffForHumans():$createdAt->format('d/m/Y H:i');
                } else {
                    $created_at = null;
                }
                $data['projects'][] = array(
                    'id' => $project['id'],
                    'project_code' => $project['project_code'],
                    'image_id' => $project['image_id'],
                    'name' => $project['name'],
                    'description' => substr($project['description'], 0, 200),
                    'keyword' => $project['keyword'],
                    'missions' => $project['missions'] ?? array(),
                    'url' => 'project/' . $project['id'],
                    'status' => $project['status'],
                    'latitude' => $project['latitude'],
                    'longitude' => $project['longitude'],
                    'price' => $project['price'],
                    'comment' => $project['comment'],
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

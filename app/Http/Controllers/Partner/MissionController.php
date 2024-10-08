<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Http\Resources\MissionResource;
use App\Models\Comment;
use App\Models\Mission;
use App\Models\Project;
use App\Services\MissionService;
use Illuminate\Http\Request;

class MissionController extends Controller
{
    protected $missionService;

    public function __construct(MissionService $missionService){
        $this->missionService = $missionService;
    }

    /**
     * Trang nhận nhiệm vụ
     */
    public function index(Request $request)
    {
        $data = array();
        $user_id = auth()->user()->id;
        $request = $request->merge(['user_id' => $user_id]);
        $project = Mission::leftJoin('projects', 'missions.project_id', '=', 'projects.id')->where('user_id', $user_id)->where('projects.status', 2)->first();
        if(empty($project)){
            $project = Project::where('status', Project::WORKING_PROJECT)->inRandomOrder()->first();
            //Còn thiếu check điều kiện số mission phải nhỏ hơn số lượt của gói 
        }
        $data['project'] = $project;
        $data['user_id'] = $user_id;
        $data['mission'] = array(
            'id' => 1
        );

        return view('pages.partner.mission.index', $data);
    }

    public function getCommentsNotInMissions($request)
    {
        $project_id = $request->project_id;
        // Check xem có id comment của dự án đã được tạo trong mission
        $comment_id = Mission::pluck('comment_id')->where('project_id', $project_id)->toArray();
        // Lấy những comment của dự án đó và chưa được dùng và không có trong mission
        $randomComment = Comment::whereNotIn('id', $comment_id)
        ->where('is_used', 0)
        ->where('project_id', $project_id)
        ->inRandomOrder()
        ->first();
        return $randomComment;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = array();
        $mission = $this->missionService->find($id);
        $data['mission'] = $mission;
        return view('pages.partner.mission.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $this->missionService->update($request, $id);
        return json_encode([
            'status' => 'success',
            'message' => 'Update mission success',
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function createMissionAjax(Request $request){
            // Check xem user có đang làm mission nào không status = 2 và thuộc dự án
            $mission = Mission::where('user_id', $request->user_id)->where('status', 2)->where('project_id', $request->project_id)->first();
            if(empty($mission)){
                $comment = $this->getCommentsNotInMissions($request);
                // Tạo nhiệm vụ
                $mission = Mission::create([
                    'user_id' => $request->user_id,
                    'project_id' => $request->project_id,
                    'comment_id' => $comment->id,
                    'status' => 2 // Đang thực hiện
                ]);
                // Cập nhật lại cái trạng thái is_used
                Comment::where('id', $comment->id)->update(['is_used' => 1]);
            }
            return json_encode([
                'status' => 'success',
                'data' => $mission
            ]);
    }
    public function missionConfirm(Request $request, string $id){
        $mission = $this->missionService->find($id);
        $project_info = Project::find($mission->project_id);
        $data['mission'] = new MissionResource($mission);
        $data['mission_id'] = $id;
        $data['link_map'] = isset($project_info->place_id)?'https://www.google.com/maps/place/?q=place_id:' . $project_info->place_id.'&reviews':'';
        return view('pages.partner.mission.confirm', $data);
    }

    public function success(Request $request){
        return view('pages.partner.mission.success');
    }

    public function histories(Request $request){
        return view('pages.partner.mission.histories');
    }
}

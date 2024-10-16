<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReCaptchaV2Request;
use App\Http\Resources\MissionResource;
use App\Models\Comment;
use App\Models\Mission;
use App\Models\Project;
use App\Models\ProjectImage;
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
        try {
            \DB::beginTransaction();
            $user_id = auth()->user()->id;
            $project = Project::join('missions', 'projects.id', '=', 'missions.project_id')->where('missions.user_id', $user_id)->where('missions.status', 2)->select('projects.*')->first();
            $projectIds = Project::where('status', Project::WORKING_PROJECT)->get()->pluck('id')->toArray();
            $mission = [];
            if(empty($project)) {
                [$project, $mission] = $this->getProjectConditions($user_id, $projectIds);
            }
            \DB::commit();
            $data = array();
            $data['project'] = $project;
            $data['user_id'] = $user_id;
            $data['mission'] = $mission ? $mission->toArray() : [];
            return view('pages.partner.mission.index', $data);
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

    }
    private function getProjectConditions($user_id, $projectIds) {
        //Check điều kiện số mission phải nhỏ hơn số lượt của gói 
        $mission = [];
        $project = Project::where('status', Project::WORKING_PROJECT)->inRandomOrder()->first();
        $countMission = Mission::where('project_id', $project->id)->where('status', 2)->count();
        $conditionPackage = true;
        $conditionSlow = true;
        // check tổng nhiệm vụ không được lớn hơn rãi chậm
        if($project->is_slow && $countMission > $project->point_slow) {
            $conditionSlow = false;
        }
        switch($project->package){
            case 1:
                $conditionPackage = $countMission < 10;
                break;
            case 2:
                $conditionPackage = $countMission < 50;
                break;
            case 3:
                $conditionPackage = $countMission < 100;
                break;
            case 4:
                $conditionPackage = $countMission < 200;
                break;
            default: 
                $conditionPackage = true;
        }
        // tính khoảng cách vị trí đối tác với dự án
        $distance = getDistanceBetweenPoints($project->latitude, $project->longitude, auth()->user()->latitude, auth()->user()->longitude);
        // Nếu tổng nhiệm vụ lớn hơn số lượng package hoặc vị trí > 20km thì random lại project
        if((!$conditionPackage || $distance['kilometers'] > 20 || !$conditionSlow) && $projectIds) {
            $projectIds = array_filter($projectIds, fn ($id) => $id != $project->id);
            $this->getProjectConditions($user_id, $projectIds);
        }
        if($projectIds) {
            // create mission
            $comment = $this->randomComment($project->id);
            $mission = Mission::create([
                'user_id' => $user_id,
                'project_id' => $project->id,
                'status' => 2,
                'comment_id' => $comment->id,
                'price' => getPriceFromPackage($project->package),
                'latitude' => $project->latitude,
                'longitude' => $project->longitude,
                'image_id' => 1
            ]);
            // Cập nhật comment đã sử dụng
            Comment::where('id', $comment->id)->update(['is_used' => 1]);
        } else {
            $project = [];
            return [$project, $mission];
        }

        return [$project, $mission];
    }

    public function getCommentsNotInMissions($request)
    {
        $project_id = $request->project_id;
        $comment_id = Mission::pluck('comment_id')->where('project_id', $project_id)->toArray();
        $randomComment = Comment::whereNotIn('id', $comment_id)
        ->where('is_used', 0)
        ->where('project_id', $project_id)
        ->inRandomOrder()
        ->first();
        return $randomComment;
    }

    private function randomComment($project_id)
    {
        $randomComment = Comment::where('is_used', 0)
        ->where('project_id', $project_id)
        ->inRandomOrder()
        ->first();
        return $randomComment; 
    }

    private function randomImage($project_id)
    {
        $randomImage = ProjectImage::where('is_used', 0)
        ->where('project_id', $project_id)
        ->inRandomOrder()
        ->first();
        return $randomImage; 
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
        $request = $request->merge(['user_id' => auth()->user()->id]);
        $missions = $this->missionService->list($request);
        $data = array(
            'missions' => $missions
        );
        $data['status_alert'] = array(
            Mission::STATUS_WATTING_SYSTEM,
            Mission::STATUS_WATTING_ADMIN
        );
        return view('pages.partner.mission.histories', $data);
    }


    public function verifyRecaptcha(Request $request){
        return redirect()->route('mission.index');
    }
}

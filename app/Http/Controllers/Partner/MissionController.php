<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Http\Resources\MissionResource;
use App\Models\Comment;
use App\Models\Mission;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Services\HistoryService;
use App\Services\MissionService;
use App\Services\ProjectImageService;
use App\Services\WalletService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class MissionController extends Controller
{
    protected $missionService,$walletService, $historyService, $projectImageService;

    public function __construct(
        MissionService $missionService,
        WalletService $walletService,
        HistoryService $historyService,
        ProjectImageService $projectImageService
    ){
        $this->missionService = $missionService;
        $this->walletService = $walletService;
        $this->historyService = $historyService;
        $this->projectImageService = $projectImageService;
    }

    /**
     * Trang nhận nhiệm vụ
     */
    public function index(Request $request)
    {
        try {
            $user_id = auth()->user()->id;
            $count_project = Project::where('status', 2)->count();
            if($count_project == 0) {
                return redirect()->back()->withErrors(['error' => 'Chưa có dự án nào được tạo. Vui lòng nhận nhiệm vụ sau!']);
            }
            $project = Project::join('missions', 'projects.id', '=', 'missions.project_id')
            ->leftJoin('comments', 'comments.id', '=', 'missions.comment_id')
            ->where('missions.user_id', $user_id)->where('projects.status', 2)->where('missions.status', 2)->select(
                'projects.*',
                'comments.comment',
                'missions.id as mission_id'
            )->first();
            if(empty($project)) {
                [$project, $mission] = $this->getProjectConditions($user_id);
            }
            $data = array();
            $data['project'] = $project;
            $data['user_id'] = $user_id;
            if(empty($project) && empty($mission)) {
                return redirect()->back()->withErrors(['error' => 'Chưa có nhiệm vụ nào được tạo. Bạn vui lòng chờ thêm nhiệm vụ!']);
            }else if(!empty($project) && empty($mission)) {
                $mission = $this->missionService->find($project->mission_id);
            }
            $data['mission'] = $mission;
            $data['link_map'] = isset($project->place_id)?'https://www.google.com/maps/place?key='.env("GOOGLE_MAP_API_KEY").'&q=place_id:' . $project->place_id.'&reviews':'';
            return view('pages.partner.mission.index', $data);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

    }
    private function getProjectConditions($user_id, $checkedProjectIds = []) {
        try{
            DB::beginTransaction();
            $projects = Project::where('status', Project::WORKING_PROJECT)
                ->whereNotIn('id', $checkedProjectIds)
                ->get()
                ->shuffle()
                ->take(1)
                ->all();
            $data = $this->createMissionByProjects($projects, $user_id);
            [$projectResult, $mission_create] = $data;

            $mission = $this->missionService->find($mission_create);
        
            // Nếu không có project nào thoả mãn, thêm project đã kiểm tra vào danh sách và gọi lại đệ quy
            if (empty($projectResult) && !empty($projects)) {
                $checkedProjectIds = array_merge($checkedProjectIds, array_column($projects, 'id'));
                return $this->getProjectConditions($user_id, $checkedProjectIds); // Gọi lại đệ quy với danh sách đã cập nhật
            }
            DB::commit();
            return array($projectResult, $mission);
        }catch(\Exception $e){
            DB::rollBack();
        }
    }

    public function createMissionByProjects($projects = [], $user_id){
        $mission = $projectResult = [];
        
        if (!empty($projects)) {
            foreach ($projects as $project) {
                $countMissionToDay = Mission::where('project_id', $project->id)
                    ->whereDate('created_at', Carbon::today())
                    ->whereIn('status', [1, 2])
                    ->count();
                    
                $countMission = Mission::where('project_id', $project->id)
                    ->whereIn('status', [1, 2])
                    ->count();
    
                // Kiểm tra điều kiện
                $conditionPackage = match ($project->package) {
                    1 => $countMission < 10,
                    2 => $countMission < 50,
                    3 => $countMission < 100,
                    4 => $countMission < 200,
                    default => true,
                };
                $conditionSlow = !$project->is_slow || $countMissionToDay <= $project->point_slow;
                $distance = getDistanceBetweenPoints($project->latitude, $project->longitude, auth()->user()->latitude, auth()->user()->longitude);
                $conditionDistance = $distance['kilometers'] <= 20;
                if ($conditionPackage && $conditionSlow && $conditionDistance) {
                    $comment = $this->randomComment($project->id);
                    if($project->has_image){
                        $image = $this->randomImage($project->id);
                    }
                    $mission = Mission::create([
                        'user_id' => $user_id,
                        'project_id' => $project->id,
                        'status' => 2,
                        'comment_id' => $comment->id,
                        'price' => 10000,
                        'latitude' => $project->latitude,
                        'longitude' => $project->longitude,
                        'image_id' => $image->id ?? null
                    ]);
                    
                    Comment::where('id', $comment->id)->update(['is_used' => 1]);
                    if(!empty($image->id)){
                        ProjectImage::where('id', $image->id)->update(['is_used' => 1]);
                    }
                    $projectResult = $project;
                    break;
                }
            }
        }
        return [$projectResult, $mission];
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

    public function showJson(string $id){
        $mission = $this->missionService->find($id);
        return response()->json([
            'data' => array(
                'mission' => $mission,
                'images' => $mission->images ?? null,
                'comments' => $mission->comments ?? null,
                'project' => $mission->project ?? null
            ),
            'title' => 'Chi tiết nhiệm vụ',
            'status' => 1
        ]);
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
        $price_plus = 0; // Cộng vào ví 10k khi hoàn thành nhiệm vụ + history
        $balance = $this->walletService->getBalance();
        $user_id = Auth::user()->id;
        if(empty($user_id)){
            return redirect()->route('login')->withErrors(['error' => 'Bạn phải đăng nhập để hoàn thêm nhiệm vụ!']);
        }
        $this->walletService->update($balance + $price_plus, $user_id);
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
        $data['link_map'] = isset($project->place_id)?'https://www.google.com/maps/place?key='.env("GOOGLE_MAP_API_KEY").'&q=place_id:' . $project->place_id.'&reviews':'';
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

    public function resultGoogleMap(string $place_id){
        $url = 'https://places.googleapis.com/v1/places/'. $place_id;
        $fields = 'id,displayName,rating,reviews,userRatingCount,location,reviews';
        $apiKey = env('GOOGLE_MAP_API_KEY');

        // Gửi request GET
        $response = Http::get($url, [
            'fields' => $fields,
            'key'    => $apiKey
        ]);

        // Kiểm tra phản hồi
        if ($response->successful()) {
            // Trả về dữ liệu JSON
            $data_map = $response->json();
            if(!empty($data_map['reviews'])) {
                foreach ($data_map['reviews'] as $key => $value) {
                    $data_map['reviews'][] = array(
                        'rating' => $value['rating'],
                        'text' => $value['text'],
                        'googleMapsUri' => $value['googleMapsUri']
                    );
                }
            }
            return response()->json([
                'title' => 'Review api google map',
                'data' => $data_map,
                'status' => 1
            ]);
        } else {
            // Xử lý lỗi
            return response()->json([
                'error' => $response->status(),
                'message' => $response->body(),
            ], $response->status());
        }
    }


    public function updateStatus(Request $request, $id){
        try{
            $validator = Validator::make($request->all(), [
                'status' => 'required|in:1,2'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'messaage' => $validator->errors()->all()
                ]);
            }
            $data = $this->missionService->updateStatus($request, $id);
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật trạng thái thành công',
                'data' => $data
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()                
            ]);
        }
    }

    public function updateNoImage(Request $request, $id){
        try{
            $data = $this->missionService->updateNoImage($request, $id);
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật trạng thái thành công',
                'data' => $data
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()                
            ]);
        }
    }

    public function updateNoReview(Request $request, $id){
        try{
            $data = $this->missionService->updateNoReview($request, $id);
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật trạng thái thành công',
                'data' => $data
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()                
            ]);
        }
    }
}

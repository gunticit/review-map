<?php

namespace App\Http\Controllers\Partner;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\MissionResource;
use App\Models\Comment;
use App\Models\Mission;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Services\CensorshipHistoryService;
use App\Services\HistoryService;
use App\Services\MissionService;
use App\Services\ProjectImageService;
use App\Services\UserService;
use App\Services\WalletService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MissionController extends Controller
{
    protected $missionService,$walletService, $historyService, $projectImageService, $userService, $censorshipHistoryService;

    public function __construct(
        MissionService $missionService,
        WalletService $walletService,
        HistoryService $historyService,
        ProjectImageService $projectImageService,
        UserService $userService,
        CensorshipHistoryService $censorshipHistoryService
    ){
        $this->missionService = $missionService;
        $this->walletService = $walletService;
        $this->historyService = $historyService;
        $this->projectImageService = $projectImageService;
        $this->userService = $userService;
        $this->censorshipHistoryService = $censorshipHistoryService;
    }

    /**
     * Trang nhận nhiệm vụ
     */
    public function index(Request $request)
    {
        try {
            $user_id = auth()->user()->id;
            $lastTimeMakeMission = $this->checkLastTimeMakeMission($user_id);
            if(!$lastTimeMakeMission) {
                return redirect()->route('wating.mission');
            }
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

            $mission = $this->missionService->find($mission_create->id);
        
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
                if($project->is_slow){
                    $percent_get_mession  = Helper::getSetting('setting_percent_slow') ?? 1;
                }else{
                    $percent_get_mession  = Helper::getSetting('setting_percent_no_slow') ?? 1;
                }
                // Kiểm tra điều kiện
                $conditionPackage = match ((int)$project->package) {
                    1 => $countMission < 10 * ceil($percent_get_mession / 100), // 10 là số câu hỏi của gói 1
                    2 => $countMission < 50 * ceil($percent_get_mession / 100), // 50 là số câu hỏi của gói 2
                    3 => $countMission < 100 * ceil($percent_get_mession / 100), // 100 là số câu hỏi của gói 2
                    4 => $countMission < 200 * ceil($percent_get_mession / 100), // 200 là số câu hỏi của gói 2
                    default => true,
                };
                $conditionSlow = !$project->is_slow || $countMissionToDay <= $project->point_slow;
                $distance = getDistanceBetweenPoints($project->latitude, $project->longitude, auth()->user()->latitude, auth()->user()->longitude);
                $kilometer_setting = Helper::getSetting('setting_distance') ?? 20;
                $conditionDistance = $distance['kilometers'] <= $kilometer_setting;
                $user_mission_price = Auth::user()->levelDetails->reward ?? 10000;
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
                        'price' => $user_mission_price,
                        'link_confirm' => null,
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
        $request = new Request();
        $request->merge(['mission_id' => $id]);
        $histories = $this->censorshipHistoryService->list($request);
        $data_history = array();
        if(!empty($histories->all())){
            foreach ($histories->all() as $history) {
                $label_status = '';
                if($history['status'] == 1){
                    $label_status = 'Duyệt thành công';
                }else if($history['status'] == 2){
                    $label_status = 'Duyệt thiếu hình ảnh';
                }else if($history['status'] == 3){
                    $label_status = 'Duyệt không thấy bình luận';
                }
                $data_history[] = array(
                    'id' => $history->id,
                    'status' => $label_status,
                    'created_at' => Carbon::parse($history->created_at)->format('d/m/Y H:i:s')
                );
            }
        }
        return response()->json([
            'data' => array(
                'mission' => $mission,
                'images' => $mission->images ?? null,
                'comments' => $mission->comments ?? null,
                'project' => $mission->project ?? null,
                'histories' => $data_history ?? null
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
        try{
            DB::beginTransaction();
                $mission = $this->missionService->update($request, $id);
                if(empty($mission)){
                    throw new \Exception('Update mission fail');
                }
                $price_plus = $this->checkMoneyByLevel();
                $user_id = Auth::user()->id;
                $wallet = $this->walletService->checkWalletUser($user_id);
                if(empty($user_id)){
                    return redirect()->route('login')->withErrors(['error' => 'Bạn phải đăng nhập để hoàn thêm nhiệm vụ!']);
                }
                $wallet_request = new Request();
                $wallet_request->merge([
                    'balance' => $wallet->balance,
                    'temporary_addition' => (int)$wallet->temporary_addition + (int)$price_plus
                ]);
                $data = $this->walletService->update($wallet_request, $user_id);
            DB::commit();
            return json_encode([
                'status' => 'success',
                'message' => 'Update mission success',
                'data' => $data
            ]);
        }catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }
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
            Mission::STATUS_WATTING_SYSTEM
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
    // 1: // Thành công, 2: // Thiếu Hình ảnh, 3: // Không thấy comment
    public function updateNoImage(Request $request, $id){
        try{
            $data = $this->missionService->updateNoImage($request, $id);
            if(!empty($data)){
                $censorshipHistory = new Request();
                $censorshipHistory->merge([
                    'mission_id' => $data->id,
                    'approver_id' => auth()->user()->id,
                    'partner_id' => $data->user_id,
                    'money' => $data->price,
                    'status' => 2, // Thiếu hình
                ]);
                $this->censorshipHistoryService->create($censorshipHistory);
            }
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

    public function waitingMission(Request $request){
        $user_id = Auth::user()->id;
        $time_waiting = $this->checkLastTimeMakeMission($user_id, 'get_time');
        return view('pages.waiting_mission',[
            'time_waiting' => $time_waiting ?? null
        ]);
    }


    public function checkLastTimeMakeMission($user_id, $type = null){
        $mission = Mission::where('user_id', $user_id)->where('status', '!=', 2)->orderBy('completed_at', 'desc')->first();
        $hour_plus = $this->checkTimeByLevel($user_id);
        if(!empty($mission)){
            $now = Carbon::now();
            // Trường hợp nhiệm vụ đã hết hạn
            if($mission->status == 6){
                $time = Carbon::createFromFormat('Y-m-d H:i:s', $mission->created_at)->addHours($hour_plus);
            }else{
                $time = Carbon::createFromFormat('Y-m-d H:i:s', $mission->completed_at)->addHours($hour_plus);
            }

            if($time <= $now){
                return true; // Nếu giờ hiện tại lớn hơn giờ đã làm trước đó + giờ theo cấp
            }
            if(!empty($type) && $type == 'get_time'){
                $timestamp = $time->timestamp * 1000;
                return $timestamp;
            }
            return false;
        }else{
            return true; // trường hợp chưa làm nhiệm vụ nào cả thì cho phép tạo mới
        }
    }

    public function checkMoneyByLevel($user_id = null){
        $user_id = $user_id ?? Auth::user()->id;
        $user_info = $this->userService->find($user_id);
        $money = 10000;
        if(!empty($user_info->level)){
            switch($user_info->level){
                case 5: 
                    $money = 14000;
                    break;
                case 4: 
                    $money = 13000;
                    break;
                case 3: 
                    $money = 12000;
                    break;
                case 2: 
                    $money = 11000;
                    break;
                case 1:
                    $money = 10000;
                    break;
                default: 
                    $money = 10000;
                    break;
            }
        }
        return $money;
    }

    public function checkTimeByLevel($user_id = null){
        $user_id = $user_id ?? Auth::user()->id;
        $user_info = $this->userService->find($user_id);
        $hour = 12;
        if(!empty($user_info->level)){
            switch($user_info->level){
                case 5: 
                    $hour = 1;
                    break;
                case 4: 
                    $hour = 2;
                    break;
                case 3: 
                    $hour = 3;
                    break;
                case 2: 
                    $hour = 6;
                    break;
                case 1:
                    $hour = 12;
                    break;
                default: 
                    $hour = 12;
                    break;
            }
        }
        return $hour;
    }   
}

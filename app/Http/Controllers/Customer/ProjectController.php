<?php

namespace App\Http\Controllers\Customer;

use App\Events\GenerateCommentSuccess;
use App\Events\ProjectImagesUploaded;
use App\Exceptions\ProcessException;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;
use App\Models\Voucher;
use App\Services\CommentService;
use App\Services\ExpenditureStatisticService;
use App\Services\HistoryService;
use App\Services\ProjectService;
use App\Services\UserService;
use App\Services\ProjectImageService;
use App\Services\WalletService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ProjectController extends Controller
{
    protected $projectService, $projectImageService, $historyService, $commentService, $userService, $walletService, $expenditureStatisticService;
    public function __construct(
        ProjectService $projectService, 
        ProjectImageService $projectImageService, 
        CommentService $commentService, 
        HistoryService $historyService,
        UserService $userService,
        WalletService $walletService,
        ExpenditureStatisticService $expenditureStatisticService
    ){
        $this->projectService = $projectService;
        $this->projectImageService = $projectImageService;
        $this->historyService = $historyService;
        $this->commentService = $commentService;
        $this->userService = $userService;
        $this->walletService = $walletService;
        $this->expenditureStatisticService = $expenditureStatisticService;
    }
    public function index(Request $request){
        $data = $this->projectService->list($request);
        $expenditure = $this->expenditureStatisticService->getAllExpenditureByUser(Auth::user()->id);
        return view('pages.customer.projects.list',[
            'projects' => $data['projects'] ?? [],
            'total' => $data['total'] ?? 0,
            'working' => $data['working'] ?? 0,
            'stopped' => $data['stopped'] ?? 0,
            'money_spent' => $expenditure ?? 0
        ]);
    }

    public function search(Request $request){
        $data = $this->projectService->list($request);
        return view('pages.customer.projects.search',[
            'projects' => $data['projects'] ?? []
        ]);
    }

    public function create(Request $request){
        set_time_limit(0);
        $user = Auth::user();
        $data = array(
            'latitude' => $user->latitude ?? '10.8299',
            'longitude' => $user->longitude ?? '106.68029'
        );
        $data['minSetting'] = Helper::getSetting('setting_min_image') ?? 10; // Mặc định 10%
        $data['maxSetting'] = Helper::getSetting('setting_max_image') ?? 10; // Mặc định 10%
        $data['setting_percent_slow'] = Helper::getSetting('setting_percent_slow') ?? 0;    
        $data['setting_price_slow'] = Helper::getSetting('setting_price_slow') ?? 0;
        return view('pages.customer.projects.create',$data);
    }

    public function store(ProjectRequest $request)
    {
        try {
            set_time_limit(0);
            DB::beginTransaction();
            $data = $this->projectService->create($request);
            $project_id = $data->id;
            
            $keyword_data = $this->processKeywords($request);
            $request->merge(['keyword' => implode(',', $keyword_data),'status' => 5]);
            $this->projectService->update($request, $project_id);
            
            [$sl_comment, $sl_image] = $this->getPackageLimits($request->package ?? null);
            if (!$this->handleComments($request, $project_id, $keyword_data, $sl_comment)) {
                return redirect()->back()->withInput();
            }
    
            if ($request->has('has_image') && $request->has_image == 1) {
                if (!$this->handleImages($request, $project_id, $sl_image)) {
                    return redirect()->back()->withInput();
                }
            }
    
            $this->logProjectHistory($data['name'], true);
            DB::commit();
    
            return redirect()->route('page.order.project', ['id' => $project_id])
                ->with('success', 'Khởi tạo dự án thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            Session::flash('error', 'Tạo dự án không thành công');
            throw new ProcessException($e);
        }
    }
    
    private function processKeywords($request)
    {
        $keyword = isset($request->keyword) ? explode(',', $request->keyword) : [];
        $keyword_value = isset($request->keyword_value) ? explode(',', $request->keyword_value) : [];
        $keyword_array = array_merge($keyword, $keyword_value);
        
        return array_values(array_filter(array_unique($keyword_array), function ($value) {
            return $value !== null && $value !== "";
        }));
    }
    
    private function getPackageLimits($package)
    {
        $limits = [
            1 => [10, 10],
            2 => [50, 50],
            3 => [100, 100],
            4 => [200, 200],
        ];
        return $limits[$package] ?? [0, 0];
    }
    
    private function handleComments($request, $project_id, $keyword_data, $sl_comment)
    {
        $requestData = request()->all();
        $files = request()->file();
        if($files){
            $request_filter = array_diff_key($requestData, $files);
        }
        $request_filter = $request_filter ?? $requestData;

        $data_comment = array_fill(0, $sl_comment, [
            'project_id' => $project_id,
            'comment' => '',
            'keyword' => implode(',', $keyword_data)
        ]);
        $this->commentService->create($data_comment);
        // event(new GenerateCommentSuccess($request_filter, $project_id, $keyword_data, $sl_comment));
        return true;
    }

    public function ajaxHandleComments(Request $request){
        $project_id = $request->project_id;
        $project_info = $this->projectService->show($project_id);
        if(empty($project_info->has_comment)){
            $this->commentService->deleteByKey('project_id', $project_id);
            $this->projectService->update([
                'has_comment' => true,
                'status' => 5,
            ], $project_id);
        }
        [$sl_comment, $sl_image] = $this->getPackageLimits($project_info->package ?? null);
        $keyword_value = !empty($project_info->keyword) ? explode(',', $project_info->keyword) : [];
        $event_request = array(
            'project_id' => $project_id,
            'keyword' => $project_info->keyword,
            'description' => $project_info->description,
            'package' => $project_info->package,
            'keyword_value' => $keyword_value
        );
        $summary_comment = $this->commentService->countDataByKey('project_id', $project_id);
        if($summary_comment >= $sl_comment && !!$project_info->has_comment){
            return response()->json([
                'status' => 0,
                'message' => 'Số lượng đã đủ vui lòng thanh toán hoặc nâng cấp gói để tạo thêm comments!'
            ]);
        }
        $this->commentService->generateComment($event_request);
        return response()->json([
            'status' => 1,
            'max_page' => ceil($summary_comment / 25),
            'message' => 'Tạo comment thành công!'
        ]);
    }
    
    private function handleImages($request, $project_id, $sl_image)
    {
        $files = $request->file('files', []);
        $quantity_images = count($files);
        
        $min_images = ceil($sl_image * (Helper::getSetting('setting_min_image') ?? 10) / 100);
        $max_images = ceil($sl_image * (Helper::getSetting('setting_max_image') ?? 10) / 100);
        
        if ($quantity_images < $min_images || $quantity_images > $max_images) {
            Session::flash('error', "Số lượng hình upload là $quantity_images không đủ để tạo dự án");
            return false;
        }

        $folder = 'uploads/' . date('Y-m') . '/' . date('d') . '/' . $project_id;
        $filePaths = [];

        foreach ($files as $file) {
            $path = $file->store($folder, 'public');
            $filePaths[] = $path;
        }

        event(new ProjectImagesUploaded($filePaths, $project_id));
        return true;
    }
    
    private function logProjectHistory($project_name, $success)
    {
        $history = [
            [
                'content' => json_encode([
                    'title' => $success ? 'Dự án khởi tạo thành công' : 'Dự án tạo không thành công',
                    'content' => $success ? "Bạn đã tạo dự án $project_name thành công!" : 'Dự án tạo không thành công',
                    'status' => $success ? 5 : 0,
                    'user_id' => Auth::user()->id
                ]),
                'user_id' => Auth::user()->id
            ]
        ];
        $this->updateHistory($history);
        Session::flash($success ? 'success' : 'error', $success ? 'Khởi tạo dự án thành công' : 'Tạo dự án không thành công');
    }
    

    public function edit($id, Request $request){
        $data = $this->projectService->show($id);
        $project_comments = $this->projectService->findWithComments($id, $request);
        if($project_comments->status !== 5){
            return redirect()->route('project.list');
        }
        if($project_comments && $project_comments->comments && !empty($project_comments->comments)){
            $comments = $project_comments->comments;
            $perPage = 15;
            $currentPage = isset($request->page) ? $request->page  : LengthAwarePaginator::resolveCurrentPage();
            $currentComments = $comments->slice(($currentPage - 1) * $perPage, $perPage)->values();
            $paginatedComments = new LengthAwarePaginator(
                $currentComments,
                $comments->count(),
                $perPage,
                $currentPage,
                ['path' => LengthAwarePaginator::resolveCurrentPath()]
            );
        }
        $project_images = $this->projectImageService->findImageByProject($id);
        $setting_price_slow = Helper::getSetting('setting_price_slow') ?? 0;
        return view('pages.customer.projects.edit',[
            'project' => $data,
            'setting_price_slow' => $setting_price_slow,
            'paginatedComments' => $paginatedComments,
            'project_info' => $project_comments,
            'project_images' => $project_images
        ]);
    }

    public function update(ProjectRequest $request, $id){
        try{
            $data = $this->projectService->update($request, $id);
            if($data){
                if ($request->has('has_image') && $request->has_image == 1) {
                    $this->projectImageService->createDataImages($request, $data->id);
                }
                $content_history = 'Bạn đã thao tác ' . checkStatus($data->status) . ' dự án ' . $data->name;
                $history = [
                    [
                        'content' => json_encode([
                            'title' => 'Cập nhật dự án',
                            'content' => $content_history,
                            'status' => true
                        ]),
                        'user_id' => Auth::user()->id
                    ]
                ];
                $this->updateHistory($history);
                Session::flash('success', 'Cập nhật dự án thành công');
                return redirect()->route('project.list');
            }
            Session::flash('error', 'Không thể cập nhật dự án');
            return redirect()->back()->withInput();
        }catch(\Exception $e){
            throw new ProcessException($e);
        }
    }

    public function updateStatus(Request $request, $id){
        try{
            $project = $this->projectService->updateStatus($request, $id);
            $content_history = 'Bạn đã thao tác ' . checkStatus($project['status'])['labelStatus'] . ' dự án ' . $project['name'];
            $history = [
                [
                    'content' => json_encode([
                        'title' => 'Cập nhật trạng thái dự án',
                        'content' => $content_history,
                        'status' => $request->status
                    ]),
                    'user_id' => Auth::user()->id
                ]
            ];
            $this->updateHistory($history);
            return response()->json([
                'status' => 'success',
                'data' => $request->status,
                'message' => 'Cập nhật thành công'
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
    
    public function wrongImages($id){
        $data = $this->projectService->wrongImages($id);
        return response()->json([
            'data' => $data
        ]);
    }

    public function updateOrderProject(Request $request){
        $data = $this->projectService->updateOrderProject($request->project_id);
        return response()->json([
            'data' => $data
        ]);
    }

    public function pageOrderProject($project_id, Request $request){
        $project_comments = $this->projectService->findWithComments($project_id, $request);
        if($project_comments && $project_comments->status !== 5){
            return redirect()->route('project.list');
        }
        if($project_comments && $project_comments->comments && !empty($project_comments->comments)){
            $comments = $project_comments->comments;
            $perPage = 25;
            $currentPage = isset($request->page) ? $request->page  : LengthAwarePaginator::resolveCurrentPage();
            $currentComments = $comments->slice(($currentPage - 1) * $perPage, $perPage)->values();
            $paginatedComments = new LengthAwarePaginator(
                $currentComments,
                $comments->count(),
                $perPage,
                $currentPage,
                ['path' => LengthAwarePaginator::resolveCurrentPath()]
            );
        }
        $price_order = 0;
        $project_price = 0;

        if($project_comments && (int)$project_comments->package){
            switch ((int)$project_comments->package) {
                case 1:
                    $project_price = 45000;
                    $price_order = 45000 * 10;
                    $quantity = 10;
                    break;
                case 2:
                    $project_price = 35000;
                    $price_order = 35000 * 50;
                    $quantity = 50;
                    break;
                case 3:
                    $project_price = 30000;
                    $price_order = 30000 * 100;
                    $quantity = 100;
                    break;
                case 4:
                    $project_price = 25000;
                    $price_order = 25000 * 200;
                    $quantity = 200;
                    break;
                default:
                    $project_price = 0;
                    $price_order = 0;
                    $quantity = 0;
                    break;
            }
        }
        $wallet_info = $this->walletService->checkWalletUser();
        $balance = $wallet_info->balance ?? 0;
        $provisional_deduction = $wallet_info->provisional_deduction ?? 0; // Số nợ trước đó
        $available_balance = $balance - $provisional_deduction; // Số dư khả dụng

        $point_slow = 0;
        if($project_comments && $project_comments->is_slow){
            $point_slow = $project_comments->point_slow;
        }
        $num_images = $this->projectImageService->countImages($project_id);
        $price_image_setting = Helper::getSetting('setting_price_image') ?? 0;
        $setting_price_slow = Helper::getSetting('setting_price_slow') ?? 0;
        $setting_percent_slow = Helper::getSetting('setting_percent_slow') ?? 0;
        $date_slow = 0;
        if($project_comments && $project_comments->is_slow){
            if($point_slow > 0){
                $date_slow = ceil($quantity / $point_slow);
            }else{
                $date_slow = ceil($quantity / ceil($quantity * $setting_percent_slow / 100));
            }
        }
        $price_slow_total = $setting_price_slow * $date_slow;
        $price_image_total = $price_image_setting * $num_images;

        $tmp_price = $price_order + $price_slow_total + $price_image_total;
        $total_price = $tmp_price + ($tmp_price * 10 / 100);

        $voucher_code = $project_comments->voucher_code ?? '';
        $discount_value = 0;
        $voucher_info = null;
        if(!empty($voucher_code)){
            $voucher_info = Voucher::where('code', $voucher_code)->select('discount_value','discount_type')->first();
            $discount_value = $voucher_info->discount_value ?? 0;
            if($voucher_info->discount_type == 'percent'){
                $total_price = $total_price - ($total_price * $discount_value / 100);
            }else{
                $total_price = $total_price - $discount_value;
            }
        }
        
        $history = [
            [
                'content' => json_encode([
                    'title' => 'Tạo dự án mới',
                    'content' => $project_comments ? 'Bạn đã tạo dự án: ' . $project_comments->name . ' thành công!'  : '',
                    'status' => 5, 
                    'user_id' => Auth::user()->id
                ]),
                'user_id' => Auth::user()->id
            ]
        ];
        $this->updateHistory($history);

        return view('pages.customer.projects.order', [
            'projects' => $paginatedComments ?? null,
            'project_info' => $project_comments,
            'price_order' => $price_order,
            'date_slow' => $date_slow,
            'project_price' => $project_price,
            'price_slow' => $price_slow_total,
            'price_image_setting' => $price_image_setting,
            'setting_price_slow' => $setting_price_slow,
            'balance' => $balance,
            'voucher_info' => $voucher_info,
            'discount_value' => $discount_value,
            'provisional_deduction' => $provisional_deduction,
            'available_balance' => $available_balance,
            'num_images' => $num_images,
            'quantity' => $quantity ?? null,
            'project_id' => $project_id,
            'point_slow' => $point_slow,
            'tmp_price' => $tmp_price,
            'total_price' => $total_price,
            'total_comment' => $comments->count(),
            'filter' => $request->all()
        ]);
    }

    public function generateCommentBySample(Request $request){
        return $this->commentService->generateCommentBySample($request);
    }

    public function updateNewComment(Request $request, string $id){
        return $this->commentService->updateNewComment($request, $id);
    }

    public function destroyByIds(Request $request){
        try{
            $data = $this->projectService->destroyByIds($request);
            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
        } catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function updateHistory($histories = array()){
        if(!empty($histories)){
            $histories = array_map(function($history){
                $history['created_by'] = Auth::user()->id;
                $history['created_at'] = date('Y-m-d H:i:s');
                $history['updated_at'] = date('Y-m-d H:i:s');
                return $history;
            }, $histories);
            $this->historyService->insert($histories);
        }
    }

    public function projectDelete(Request $request){
        return $this->projectService->destroyByIds($request);
    }

    public function generateKeyword(Request $request){
        $keywords = $this->projectService->generateKeyword($request);
        return response()->json([
            'status' => 'success',
            'data' => $keywords,
            'message' => 'Tạo danh sách từ khóa thành công'
        ]);
    }
}

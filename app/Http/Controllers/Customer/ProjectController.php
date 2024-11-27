<?php

namespace App\Http\Controllers\Customer;

use App\Exceptions\ProcessException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;
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
        $user = Auth::user();
        $data = array(
            'latitude' => $user->latitude ?? '10.8299',
            'longitude' => $user->longitude ?? '106.68029'
        );
        return view('pages.customer.projects.create',$data);
    }

    public function store(ProjectRequest $request){
        try{
            DB::beginTransaction();
            $data = $this->projectService->create($request);
            $project_id = $data->id;
            $keyword = isset($request->keyword) ? explode(',', $request->keyword): array();
            $keyword_value = isset($request->keyword_value) ? explode(',', $request->keyword_value): array();
            $keyword_array = array_merge($keyword, $keyword_value);
            $unique_keyword_array = array_unique($keyword_array);
            $keyword_data = array_filter($unique_keyword_array, function($value) {
                return $value !== null && $value !== "";
            });
            $request = $request->merge([
                'keyword' => implode(',', $keyword_data)
            ]);
            $this->projectService->update($request, $project_id);
            if($data && $project_id){
                $request->request->add(['project_id' => $project_id]);
                $request->request->add(['noJson' => true]);
                $comments = $this->commentService->generateComment($request);
                if(!empty($comments)){
                    $comments = explode('|', $comments);
                    $sl_comment = 10;
                    if(isset($request->package)){
                        switch($request->package){
                            case '1':
                                $sl_comment = 10;
                                break;
                            case '2':
                                $sl_comment = 50;
                                break;
                            case '3':
                                $sl_comment = 100;
                                break;
                            default: 
                                $sl_comment = 200;
                                break;
                        }
                    }
                    if(count($comments) < $sl_comment){
                        $comments = $this->commentService->generateComment($request);
                        $comments = explode('|', $comments);
                    }
                    if(!empty($comments)){
                        foreach($comments as $comment){
                            if(!empty($comment) && strlen(trim($comment)) > 0){
                                $data_comment = array(
                                    'project_id' => $project_id,
                                    'comment' => $comment,
                                    'keyword' => implode(',', $keyword_data)
                                );
                                $this->commentService->create($data_comment);
                            }
                        }
                    }
                }
                if ($request->has('has_image') && $request->has_image == 1) {
                    $this->projectImageService->createDataImages($request, $project_id);
                }
                $content_history = [
                    'title' => 'Dự án khởi tạo thành công',
                    'content' => 'Dự án khởi tạo thành công vào lúc: ' . $data['created_at'],
                    'status' => 5, // Chờ thanh toán
                    'user_id' => Auth::user()->id
                ];
                $this->historyService->create([
                    'content' => json_encode($content_history),
                    'user_id' => Auth::user()->id
                ]);
                Session::flash('success', 'Khởi tạo dự án thành công');
                DB::commit();
                return redirect()->route('page.order.project', ['id' => $project_id])
                ->with('success', 'Khởi tạo dự án thành công');
            }
            $content_history = [
                'title' => 'Dự án tạo không thành công',
                'content' => 'Dự án tạo không thành công vào lúc: ' . $data['created_at'],
                'status' => 0,
                'user_id' => Auth::user()->id
            ];
            $this->historyService->create([
                'content' => json_encode($content_history),
                'user_id' => Auth::user()->id
            ]);
            Session::flash('error', 'Tạo dự án không thành công');
            return redirect()->back()->withInput();
        }catch(\Exception $e){
            DB::rollBack();
            throw new ProcessException($e);
        }
    }

    public function edit($id){
        $data = $this->projectService->show($id);
        return view('pages.customer.projects.edit',[
            'project' => $data
        ]);
    }

    public function update(ProjectRequest $request, $id){
        try{
            $data = $this->projectService->update($request, $id);
            if($data){
                if ($request->has('has_image') && $request->has_image == 1) {
                    $this->projectImageService->createDataImages($request, $data->id);
                }
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
            $this->projectService->updateStatus($request, $id);
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
        $price_order = 0;

        if($project_comments->package){
            switch ($project_comments->package) {
                case 1:
                    $price_order = 45000 * 10;
                    $quantity = 10;
                    break;
                case 2:
                    $price_order = 35000 * 50;
                    $quantity = 50;
                    break;
                case 3:
                    $price_order = 30000 * 100;
                    $quantity = 100;
                    break;
                case 4:
                    $price_order = 25000 * 200;
                    $quantity = 200;
                    break;
                default:
                    $price_order = 0;
                    $quantity = 0;
                    break;
            }
        }
        $point_slow = 0;
        $money_slow = 0;
        if($project_comments->is_slow){
            $point_slow = $project_comments->point_slow;
            $money_slow = 10000;
        }
        $wallet_info = $this->walletService->checkWalletUser();
        $balance = $wallet_info->balance ?? 0;
        $provisional_deduction = $wallet_info->provisional_deduction ?? 0; // Số nợ trước đó
        $available_balance = $balance - $provisional_deduction; // Số dư khả dụng
        $surplus = $available_balance - ($price_order + $money_slow + ($price_order + $money_slow) * 0.1); // Số dư tạm tính khi thanh toán
        $tmp_price = $price_order + ($point_slow > 0 ? 10000 : 0);
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
        
        return view('pages.customer.projects.order', [
            'projects' => $paginatedComments,
            'project_info' => $project_comments,
            'price_order' => $price_order,
            'balance' => $balance,
            'voucher_info' => $voucher_info,
            'discount_value' => $discount_value,
            'provisional_deduction' => $provisional_deduction,
            'available_balance' => $available_balance,
            'surplus' => $surplus,
            'quantity' => $quantity,
            'project_id' => $project_id,
            'point_slow' => $point_slow,
            'tmp_price' => $tmp_price,
            'total_price' => $total_price
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
}

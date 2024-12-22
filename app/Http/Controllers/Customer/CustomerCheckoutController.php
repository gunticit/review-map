<?php

namespace App\Http\Controllers\Customer;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Voucher;
use App\Services\ExpenditureStatisticService;
use App\Services\ProjectService;
use App\Services\TransactionHistoryService;
use App\Services\HistoryService;
use App\Services\ProjectImageService;
use App\Services\WalletService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerCheckoutController extends Controller
{
    protected $projectService, $transactionHistoryService, $historyService, $walletService, $expenditureStatisticService, $projectImageService;
    public function __construct(
        ProjectService $projectService, 
        TransactionHistoryService $transactionHistoryService, 
        HistoryService $historyService,
        WalletService $walletService,
        ExpenditureStatisticService $expenditureStatisticService,
        ProjectImageService $projectImageService
    )
    {
        $this->projectService = $projectService;
        $this->transactionHistoryService = $transactionHistoryService;
        $this->walletService = $walletService;
        $this->expenditureStatisticService = $expenditureStatisticService;
        $this->historyService = $historyService;
        $this->projectImageService = $projectImageService;
    }
    public function confirmCheckout(Request $request){
        try{
            DB::beginTransaction();
            $project_id = $request->project_id;
            $project = $this->projectService->show($project_id);
            $project_comments = $this->projectService->findWithComments($project_id, $request);
            $price_order = 0;
            if((int)$project_comments->package){
                $price_order = match ((int)$project_comments->package) {
                    1 => 45000 * 10,
                    2 => 35000 * 50,
                    3 => 30000 * 100,
                    4 => 25000 * 200,
                    default => 0
                };
                $quantity = match ((int)$project_comments->package) {
                    1 => 10,
                    2 => 50,
                    3 => 100,
                    4 => 200,
                    default => 0
                };
            }
            $point_slow = 0;
            if($project_comments->is_slow){
                $point_slow = $project_comments->point_slow;
            }
            $num_images = $this->projectImageService->countImages($project_id);
            $price_image_setting = Helper::getSetting('setting_price_image') ?? 0;
            $setting_price_slow = Helper::getSetting('setting_price_slow') ?? 0;
            $setting_percent_slow = Helper::getSetting('setting_percent_slow') ?? 0;
            $date_slow = 0;
            if($project_comments->is_slow){
                if($point_slow > 0){
                    $date_slow = ceil($quantity / $point_slow);
                }else{
                    $date_slow = ceil($quantity / ceil($quantity * $setting_percent_slow / 100));
                }
            }
            $price_slow_total = $setting_price_slow * $date_slow;
            $price_image_total = $price_image_setting * $num_images;
            $temp_price_order = $price_order + $price_slow_total + $price_image_total;
            Project::where('id', $project_id)->update(['price' => $price_order]);
            $price_order = $temp_price_order + $temp_price_order * 0.1; // Cộng VAT
            $wallet_info = $this->walletService->checkWalletUser();
            $balance = $wallet_info->balance ?? 0; // Số tiền

            $voucher_code = $project_comments->voucher_code ?? '';
            $discount_value = 0;
            $voucher_info = null;
            if(!empty($voucher_code)){
                $voucher_info = Voucher::where('code', $voucher_code)->select('discount_value','discount_type')->first();
                $discount_value = $voucher_info->discount_value ?? 0;
                if($voucher_info->discount_type == 'percent'){
                    $total_price = $price_order - ($price_order * $discount_value / 100);
                }else{
                    $total_price = $price_order - $discount_value;
                }
            }else{
                $total_price = $price_order;
            }
            $provisional_deduction = $wallet_info->provisional_deduction ?? 0; // Đã dùng tạm thời
            $provisional_deduction_new = $total_price + $provisional_deduction;
            $new_balance = $balance - $provisional_deduction_new;
            $data_transaction = array(
                'wallet_id' => $wallet_info->id,
                'amount' => $total_price,
                'type' => 'payment',
                'status' => $new_balance > 0 ? 'completed' : 'failed',
                'reference_id' => strtoupper(uniqid('PAYMENT_')),
                'transaction_code' => strtoupper(uniqid('PAYMENT_'))
            );
            $transaction = $this->transactionHistoryService->create($data_transaction);
            $data_expenditure = array(
                'user_id' => Auth::user()->id,
                'month' => Carbon::now()->format('Y-m'),
                'money' => $price_order
            );
            $this->updateExpenditureStatistic($data_expenditure);
            
            $history = [
                [
                    'content' => json_encode([
                        'title' => 'Thanh toán dự án',
                        'content' => 'Bạn đã thanh toán dự án: ' . $project_comments->name . ' với số tiền ' . formatCurrency($total_price) .' thành công!',
                        'status' => 5, 
                        'user_id' => Auth::user()->id
                    ]),
                    'user_id' => Auth::user()->id
                ]
            ];
            if(!empty($voucher_info->discount_type)){
                $history = [
                    ...$history,
                    [
                        'content' => json_encode([
                            'title' => 'Voucher đã sử dụng',
                            'content' => 'Bạn đã sử dụng dụng ' . $project_comments->voucher_code . ' với trị giá giảm ' . $discount_value . ($voucher_info->discount_type == 'percent' ? '%' : 'đ'),
                            'status' => 5, 
                            'user_id' => Auth::user()->id
                        ]),
                        'user_id' => Auth::user()->id
                    ]
                ];
            }
            $this->updateHistory($history);
            if ($transaction && $new_balance > 0) {
                $request = $request->merge([
                    'balance' => $new_balance,
                    'provisional_deduction' => 0,
                    'user_id' => Auth::user()->id
                ]);
                $check = $this->walletService->update($request, $wallet_info->id);
                if($check){
                    $project->update([
                        'status' => 2, // 2: Đang thực hiện | 5: Chờ thanh toán
                        'updated_at' => Carbon::now()
                    ]);
                }
                DB::commit();
                return response()->json([
                    'status' => 'success',
                    'data' => $transaction
                ]);
            } else {
                DB::rollback();
                return response()->json([
                    'status' => 'error',
                    'message' => 'Giao dịch thất bại!'
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function updateExpenditureStatistic($data){
        return $this->expenditureStatisticService->updateExpenditureStatistic($data);
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
}

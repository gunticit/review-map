<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\ExpenditureStatisticService;
use App\Services\ProjectService;
use App\Services\TransactionHistoryService;
use App\Services\WalletService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerCheckoutController extends Controller
{
    protected $projectService, $transactionHistoryService, $walletService, $expenditureStatisticService;
    public function __construct(
        ProjectService $projectService, 
        TransactionHistoryService $transactionHistoryService, 
        WalletService $walletService,
        ExpenditureStatisticService $expenditureStatisticService
    )
    {
        $this->projectService = $projectService;
        $this->transactionHistoryService = $transactionHistoryService;
        $this->walletService = $walletService;
        $this->expenditureStatisticService = $expenditureStatisticService;
    }
    public function confirmCheckout(Request $request){
        // try{
        //     DB::beginTransaction();
            $project_id = $request->project_id;
            $project = $this->projectService->show($project_id);
            $project_comments = $this->projectService->findWithComments($project_id, $request);
            $price_order = 0;
            if($project_comments->package){
                $price_order = match ($project_comments->package) {
                    1, "1" => 45000 * 10,
                    2, "2" => 35000 * 50,
                    3, "3" => 30000 * 100,
                    4, "4" => 25000 * 200,
                    default => 0
                };
            }
            if($project_comments->is_slow){
                $price_order = $price_order + 10000;
            }
            $temp_price_order = $price_order;
            Project::where('id', $project_id)->update(['price' => $price_order]);
            $price_order = $temp_price_order + $price_order * 0.1; // Cộng VAT
            $wallet_info = $this->walletService->checkWalletUser();
            $balance = $wallet_info->balance ?? 0; // Số tiền
            $provisional_deduction = $wallet_info->provisional_deduction ?? 0; // Đã dùng tạm thời
            $provisional_deduction_new = $price_order + $provisional_deduction;
            $surplus = $balance - $provisional_deduction_new;
            $data_transaction = array(
                'wallet_id' => $wallet_info->id,
                'amount' => $price_order,
                'type' => 'payment',
                'status' => $surplus > 0 ? 'completed' : 'failed',
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
            if ($transaction && $surplus > 0) {
                $request = $request->merge([
                    'balance' => $balance - $price_order,
                    'user_id' => Auth::user()->id
                ]);
                $check = $this->walletService->update($request, $wallet_info->id);
                if($check){
                    $project->update([
                        'status' => 2, // 2: Đang thực hiện | 5: Chờ thanh toán
                        'updated_at' => Carbon::now()
                    ]);
                }
                // DB::commit();
                return response()->json([
                    'status' => $surplus > 0 ? 'success' : 'error',
                    'data' => $transaction
                ]);
            } else {
                // DB::rollback();
                return response()->json([
                    'status' => 'error',
                    'message' => 'Project not found'
                ]);
            }
        // }catch(\Exception $e){
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => $e->getMessage()
        //     ]);
        // }
    }

    public function updateExpenditureStatistic($data){
        return $this->expenditureStatisticService->updateExpenditureStatistic($data);
    }
}

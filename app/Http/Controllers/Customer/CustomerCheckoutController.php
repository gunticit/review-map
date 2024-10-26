<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\ProjectService;
use App\Services\TransactionHistoryService;
use App\Services\WalletService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerCheckoutController extends Controller
{
    protected $projectService, $transactionHistoryService, $walletService;
    public function __construct(ProjectService $projectService, TransactionHistoryService $transactionHistoryService, WalletService $walletService)
    {
        $this->projectService = $projectService;
        $this->transactionHistoryService = $transactionHistoryService;
        $this->walletService = $walletService;
    }
    public function confirmCheckout(Request $request){
        $project = $this->projectService->show($request->project_id);
        $project_comments = $this->projectService->findWithComments($request->project_id, $request);
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
            'reference_id' => 'PAYMENT_'.time(),
        );
        $transaction = $this->transactionHistoryService->create($data_transaction);
        if ($project && $transaction) {
            $data = $project->update([
                'status' => $surplus > 0 ? 2 : 5, // 2: Đang thực hiện | 5: Chờ thanh toán
                'updated_at' => Carbon::now()
            ]);
            $data_wallet = array(
                'user_id' => Auth::user()->id,
                'balance' => $balance,
                
            );
            $this->walletService->update($data_wallet, $wallet_info->id);
            return response()->json([
                'status' => $surplus > 0 ? 'success' : 'error',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Project not found'
            ]);
        }
    }
}

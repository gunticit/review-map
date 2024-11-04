<?php

namespace App\Http\Controllers;

use App\Services\PaymentMethodService;
use App\Models\CertificationAccount;
use App\Models\TransactionHistory;
use App\Models\Wallet;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Classes\Onepay;
use App\Services\TransactionHistoryService;

class WalletController extends Controller
{
    protected $walletService, $paymentMethodService, $onepay, $transactionHistoryService;

    public function __construct(
        WalletService $walletService,
        PaymentMethodService $paymentMethodService,
        TransactionHistoryService $transactionHistoryService,
        Onepay $onepay
    ) {
        $this->walletService = $walletService;
        $this->paymentMethodService = $paymentMethodService;
        $this->onepay = $onepay;
        $this->transactionHistoryService = $transactionHistoryService;
    }
    public function index(Request $request)
    {
        $data['balance'] = $this->walletService->getBalance();
        $data['transaction_histories'] = $this->walletService->getTransactionHistories();
        $data['payment_methods'] = $this->paymentMethodService->list($request);
        return view('pages.wallet.list', $data);
    }

    public function withdraw()
    {
        $user_info = Auth::user();
        $certificationAccount = $user_info->certificationAccount;
        if(Auth::user()->getRoleNames()->first() == 'partner'){
            $balance = $this->walletService->getBalance();
        }
        $histories = $this->transactionHistoryService->listHistoriesByUser($user_info->id);
        return view('pages.wallet.withdraw', [
            'certificationAccount' => $certificationAccount,
            'user_info' => $user_info,
            'balance' => $balance,
            'withdraws' => $histories
        ]);
    }
    public function setupWalletAndDeposit(Request $request)
    {
        if ($request->input('method_payment') == 'onepay') {
            $amount = $request->input('depositAmountCustom') ? $request->input('depositAmountCustom') : $request->input('depositAmount');
            $ticketNo = $request->ip();
            $reference_id = strtoupper(uniqid('ONEPAY_'));
            $data = [
                'amount' => $amount,
                'ticketNo' => $ticketNo,
                'reference_id' => $reference_id,
            ];
            if ($request->input('method_payment') == 'onepay') {
                $response = $this->onepay->payment($data);
                if ($response['errorCode'] == 0) {
                    return redirect()->away($response['url']);
                }
            }
        }
        return redirect()->back()->with(['error' => 'Phương thức thanh toán chưa hỗ trợ']);

    }
    public function createVerify()
    {
        return view('pages.wallet.verify.create', [
            'heading_title' => 'Xác thực tài khoản'
        ]);
    }

    public function storeVerify(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'contract' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'front_id_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'back_id_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::beginTransaction();
            $data = $validator->validated();
            $certificationAccount = CertificationAccount::create([
                'user_id' => Auth::user()->id,
                'contract' => $data['contract']->store('images/certification_accounts/contract', 'public'),
                'front_id_image' => $data['front_id_image']->store('images/certification_accounts/front_id_image', 'public'),
                'back_id_image' => $data['back_id_image']->store('images/certification_accounts/back_id_image', 'public'),
                'created_by' => Auth::user()->id,
            ]);
            DB::commit();
            if ($certificationAccount) {
                return redirect()->route('wallet.withdraw')->with('success', 'Xác thực tài khoản thành công');
            }
            return redirect()->back()->with('error', 'Xác thực tài khoản thất bại');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function storeTransactionHistory(Request $request)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'amount' => 'required|numeric',
                'payment_method_id' => 'required',
                'all_amount' => 'nullable',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = $validator->validated();

            $wallet = $this->walletService->checkWalletUser();
            if ($wallet->balance < $data['amount']) {
                return redirect()->back()->with('error', 'Số dư không đủ');
            }
            if($data['amount'] < 0){
                return redirect()->back()->with('error', 'Vui lòng nhập số tiền >= 50.000 VND');
            }
            if(!empty($request->all_amount)){
                $wallet->balance = 0;
            }else{
                $wallet->balance -= $data['amount'];
            }
            $wallet->save();

            $transactionHistory = TransactionHistory::create([
                'wallet_id' => $wallet->id,
                'type' => 'withdraw',
                'amount' => $data['amount'],
                'transaction_code' => strtoupper(uniqid('WITHDRAW_')),
                'status' => 'pending',
                'payment_method_id' => $data['payment_method_id'],
                'reference_id' => strtoupper(uniqid('WITHDRAW_')),
                'created_by' => Auth::user()->id,
            ]);

            DB::commit();

            if ($transactionHistory) {
                return redirect()->route('wallet.withdraw')->with('success', 'Rút tiền thành công');
            }

            return redirect()->back()->with('error', 'Rút tiền thất bại');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }

    }
}

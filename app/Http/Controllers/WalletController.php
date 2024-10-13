<?php

namespace App\Http\Controllers;

use App\Models\CertificationAccount;
use App\Models\TransactionHistory;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class WalletController extends Controller
{

    
    public function __construct(){
    }
    public function index(){
        return view('pages.wallet.list');
    }
    public function withdraw() {
        $user = Auth::user();
        $certificationAccount = $user->certificationAccount;
        return view('pages.wallet.withdraw', compact('certificationAccount'));
    }

    public function createVerify() {
        return view('pages.wallet.verify.create', [
            'heading_title' => 'Xác thực tài khoản'
        ]);
    }

    public function storeVerify(Request $request) {
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

    public function storeTransactionHistory(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'amount' => 'required|numeric',
                'payment_method_id' => 'required',
                'all_amount' => 'nullable',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = $validator->validated();
            
            DB::beginTransaction();
            $wallet = Wallet::where('user_id', Auth::user()->id)->first();
            
            if ($wallet->balance < $data['amount']) {
                return redirect()->back()->with('error', 'Số dư không đủ');
            }

            $wallet->balance -= $data['amount'];
            $wallet->save();

            $transactionHistory = TransactionHistory::create([
                'wallet_id' => $wallet->id,
                'type' => 'withdraw',
                'amount' => $data['amount'],
                'status' => 'completed',
                'payment_method_id' => $data['payment_method_id'],
                'reference_id' => uniqid('TRX-'),
                'created_by' => Auth::user()->id,
            ]);

            DB::commit();

            if ($transactionHistory) {
                return redirect()->route('wallet.withdraw')->with('success', 'Rút tiền thành công');
            }

            return redirect()->back()->with('error', 'Rút tiền thất bại');
        } catch (\Throwable $th) {
            DB::rollBack();
            TransactionHistory::create([
                'wallet_id' => $wallet->id,
                'type' => 'withdraw',
                'amount' => $data['amount'],
                'status' => 'failed',
                'payment_method_id' => $data['payment_method_id'],
                'reference_id' => uniqid('TRX-'),
                'created_by' => Auth::user()->id,
            ]);
            return redirect()->back()->with('error', $th->getMessage());
        }

    }
}

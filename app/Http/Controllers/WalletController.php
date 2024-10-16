<?php

namespace App\Http\Controllers;

use App\Exceptions\ProcessException;
use App\Services\WalletService;
use Illuminate\Http\Request;

class WalletController extends Controller
{   
    protected $walletService;
    public function __construct(
        WalletService $walletService
    ){
        $this->walletService = $walletService;
    }
    public function index(){
        $balance = $this->walletService->getBalance()?->balance ?? 0;
        $data['balance'] = formatCurrency($balance, '₫');
        $data['transaction_histories'] = $this->walletService->getTransactionHistories();
        return view('pages.wallet.list', $data);
    }
    public function withdraw() {
        return view('pages.wallet.withdraw');
    }
    public function deposit() {
        return view('pages.wallet.deposit');
    }
    public function walletDeposit(Request $request) {
        try{
            $this->walletService->walletDeposit($request);
            return redirect()->back()->with('success', 'Giao dịch động ký thành công');
        }catch(\Exception $e){
            return redirect()->back()->with('success', 'Giao dịch động ký không thành công');
        }
    }
}

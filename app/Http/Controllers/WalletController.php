<?php

namespace App\Http\Controllers;

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
        $data['balance'] = $this->walletService->getBalance();
        $data['transaction_histories'] = $this->walletService->getTransactionHistories();
        return view('pages.wallet.list', $data);
    }
    public function withdraw() {
        return view('pages.wallet.withdraw');
    }
}

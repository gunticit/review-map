<?php

namespace App\Http\Controllers;

use App\Services\PaymentMethodService;
use App\Services\WalletService;
use Illuminate\Http\Request;

class WalletController extends Controller
{   
    protected $walletService, $paymentMethodService;
    public function __construct(
        WalletService $walletService,
        PaymentMethodService $paymentMethodService
    ){
        $this->walletService = $walletService;
        $this->paymentMethodService = $paymentMethodService;
    }
    public function index(Request $request){
        $data['balance'] = $this->walletService->getBalance();
        $data['transaction_histories'] = $this->walletService->getTransactionHistories();
        $data['payment_methods'] = $this->paymentMethodService->list($request);
        return view('pages.wallet.list', $data);
    }
    public function withdraw() {
        return view('pages.wallet.withdraw');
    }
}

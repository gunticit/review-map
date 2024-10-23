<?php

namespace App\Http\Controllers\Payment;

use App\Classes\Onepay;
use App\Http\Controllers\Controller;
use App\Services\WalletService;
use App\Services\PaymentMethodService;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use \App\Traits\OnepayTrait;


class OnepayController extends Controller
{
    use OnepayTrait;
    protected $onepay, $walletService;

    public function __construct(
        WalletService $walletService,
        Onepay $onepay
    ) {
        $this->walletService = $walletService;
        $this->onepay = $onepay;
    }
    public function onepay_return(Request $request)
    {
        // kiểm tra dữ liệu hợp lệ
        $validator = $this->validateResultRequest($request);
        if (!$validator['success']) {
            return view('pages.wallet.list', [
                'error' => $validator['message'],
            ]);
        }
        $responseCode = $request->get('vpc_TxnResponseCode');
        $reference_id = $request->input('vpc_MerchTxnRef');
        $amount = $request->input('vpc_Amount') / 100;
        if ($responseCode == '0') {
            $this->walletService->updateWalletandTransactinon($amount, $reference_id);
            return redirect()->route('wallet')->with('success', 'Giao dịch thành công - Approved');
        }
        return redirect()->route('wallet')->with('error', $this->getResponseDescription($responseCode));
    }

    public function onepay_ipn(Request $request)
    {
        $merchTxnRef = $request->get('vpc_MerchTxnRef');

        $validator = $this->validateIpnRequest($request);
        if (!$validator['success']) {
            return view('pages.wallet.list', [
                'error' => $validator['message'],
            ]);
        }
        $responseCode = $request->get('vpc_TxnResponseCode');
        $reference_id = $merchTxnRef;
        $amount = $request->input('vpc_Amount') / 100;
        if ($responseCode == '0') {
            // $this->walletService->updateWalletandTransactinon($amount, $reference_id);
            $response['success'] = true;
        } else {
            $response['success'] = false;
        }
        $responseCode = ($responseCode != 0) ? 1 : 0;
        $desc = $response['success'] ? 'success' : 'fail';

        return "responsecode={$responseCode}&desc=confirm-{$desc}";
    }
}

<?php

namespace App\Http\Controllers\Payment;

use App\Classes\Onepay;
use App\Http\Controllers\Controller;
use App\Services\HistoryService;
use App\Services\WalletService;
use Illuminate\Http\Request;
use \App\Traits\OnepayTrait;


class OnepayController extends Controller
{
    use OnepayTrait;
    protected $onepay, $walletService, $historyService;

    public function __construct(
        WalletService $walletService,
        Onepay $onepay,
        HistoryService $historyService
    ) {
        $this->walletService = $walletService;
        $this->onepay = $onepay;
        $this->historyService = $historyService;
    }
    public function onepay_return(Request $request)
    {
        // kiểm tra dữ liệu hợp lệ
        $validator = $this->validateResultRequest($request);
        $amount = $request->input('vpc_Amount') / 100;
        if (!$validator['success']) {
            return view('pages.wallet.list', [
                'error' => $validator['message'],
            ]);
        }
        $responseCode = $request->get('vpc_TxnResponseCode');
        $reference_id = $request->input('vpc_MerchTxnRef');
        if ($responseCode == '0') {
            $this->walletService->updateWalletandTransactinon($amount, $reference_id);
            $this->historyService->create([
                'user_id' => auth()->user()->id,
                'content' => json_encode([
                    'title' => 'Nạp tiền tài khoản',
                    'status' => 'success',
                    'content' => 'Nạp '.formatCurrency($amount).'  thành công vào lúc '.date('d-m-Y H:i:s'),
                ]),
            ]);
            return redirect()->route('wallet')->with('success', 'Giao dịch thành công - Approved');
        }
        return redirect()->route('wallet')->with('error', $this->getResponseDescription($responseCode));
    }

    public function onepay_ipn(Request $request)
    {
        $reference_id = $request->get('vpc_MerchTxnRef');
        $amount = $request->input('vpc_Amount') / 100;
        $validator = $this->validateIpnRequest($request);
        if (!$validator['success']) {
            return view('pages.wallet.list', [
                'error' => $validator['message'],
            ]);
        }
        $responseCode = $request->get('vpc_TxnResponseCode');
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

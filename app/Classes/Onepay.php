<?php
namespace App\Classes;
use \App\Traits\OnepayTrait;

class Onepay
{
    use OnepayTrait;
    public function __construct()
    {
    }

    public function payment($data)
    {
        // $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $configOnepay = config('onepay');

        $vpc_MerchTxnRef = $data['reference_id'];
        $vpc_OrderInfo = "THANHTOAN_KHACHHANG_RIVI";
        $amount = 0;
        if(isset($data['amount']) && $data['amount'] > 0 && $data['amount'] != 'other') {
            $amount = $data['amount'];
        }
        $vpc_Amount = $amount * $configOnepay['amount_exchange'];

        $inputData = array(
            'vpc_AccessCode' => config('onepay.access_code'),
            'vpc_Currency' => config('onepay.currency'),
            'vpc_Command' => config('onepay.command'),
            'vpc_Locale' => config('onepay.locale'),
            'vpc_Merchant' => config('onepay.merchant_id'),
            'vpc_ReturnURL' => config('onepay.return_url'),
            'vpc_Version' => config('onepay.version'),
            "vpc_Currecy" => config('onepay.currency'),
            "vpc_MerchTxnRef" => $vpc_MerchTxnRef,
            "vpc_Amount" => $vpc_Amount,
            "vpc_OrderInfo" => $vpc_OrderInfo,
            'vpc_TicketNo' => $data['ticketNo'],
        );

        ksort($inputData);

        return $this->makePayUrl($inputData);
    }


    private function makePayUrl($hashData)
    {
        $stringHashData = '';
        $url = config('onepay.do_url');
        $url .= '?Title=' . urlencode(config('onepay.title'));
        foreach ($hashData as $key => $value) {
            $url .= '&' . urlencode($key) . '=' . urlencode($value);
            $stringHashData .= $key . '=' . $value . '&';
        }
        $stringHashData = trim($stringHashData, characters: '&');
        $secureHash = $this->secure_hash_encode($stringHashData);
        $url .= '&vpc_SecureHash=' . $secureHash;

        return ['errorCode' => 0, 'url' => $url, 'secureHash' => $secureHash];
    }

}

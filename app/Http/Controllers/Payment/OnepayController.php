<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OnepayController extends Controller
{
    public function callback(Request $request){
        dd($request);
    }

    public function testOpenPay(){
        // URL mà bạn cung cấp
        $url = 'https://mtf.onepay.vn/paygate/vpcpay.op?vpc_Version=2&vpc_Currency=VND&vpc_Command=pay&vpc_AccessCode=6BEB2566&vpc_Merchant=TESTONEPAY31&vpc_Locale=vn&vpc_ReturnURL=http://quantri.review-map.test/payment/onepay/callback&vpc_MerchTxnRef=ORDER1&vpc_OrderInfo=Nap Tien 1&vpc_Amount=2500000&vpc_TicketNo=127.0.0.1&vpc_CardList=null&AgainLink=https://khachhang.review-map.test/customer/wallet&Title=Nạp tiền ứng dụng RIvi&vpc_Customer_Phone=0979289479&vpc_Customer_Email=hungdoan.it95@gmail.com&vpc_Customer_Id=1&user_1=zxc&vpc_SecureHash=6D0870CDE5F24F34F3915FB0045120D6';
    
        // Thực hiện gọi API
        $response = Http::get($url);
    
        // Kiểm tra kết quả
        if ($response->successful()) {
            // Xử lý khi thành công
            return $response->body();
        } else {
            // Xử lý khi thất bại
            return $response->status();
        }
    }
}

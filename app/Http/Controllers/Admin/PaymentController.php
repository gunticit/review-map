<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $paymentService;
    public function __construct(PaymentService $paymentService = null) {
        $this->paymentService = $paymentService;
    }
    public function index(){

        return view('admin.payment.index');
    }
    public function handlePayOSWebhook(Request $request){
        $this->paymentService->handlePayOSWebhook($request);
        return response()->json(['message' => 'success'], 200);
    }
}

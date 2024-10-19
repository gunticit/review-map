<?php

namespace App\Services;

use App\Repositories\Payment\PaymentRepositoryInterface;
use App\Http\Resources\PaymentResource;
use App\Models\Project;
use Illuminate\Validation\ValidationException;
use PayOS\PayOS;

class PaymentService {
    protected $orderRepository;

    public function __construct(
        PaymentRepositoryInterface $orderRepository,
    )
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * Authenticates the order with the given credentials.
     *
     * @param array $credentials The order's login credentials.
     * @return mixed|null The authenticated order if successful, null otherwise.
     * @throws ValidationException
     */

    public function list($request){
        $orders = $this->orderRepository->list($request);
        $orders = PaymentResource::collection($orders)->resource;
        $working = 0;
        $stopped = 0;
        foreach($orders as $order){
            if($order->status == Project::WORKING_PROJECT){
                $working++;
            }
            if($order->status == Project::STOPPED_PROJECT){
                $stopped++;
            }
        }
        $data = array(
            'orders' => $orders,
            'total' => count($orders),
            'working' => $working,
            'stopped' => $stopped
        );
        return $data;
    }

    public function fullList($request){
        $orders = $this->orderRepository->list($request);
        return $orders;
    }

    public function create($request){
        $order = $this->filterData($request);
        $data = $this->orderRepository->create($order);
        return $data;
    }

    public function show($id){
        $data = $this->orderRepository->find($id);
        return $data;
    }

    public function update($request, $id){
        $order = $this->filterData($request);
        $data = $this->orderRepository->update($order, $id);
        return $data; 
    }

    public function handlePayOSWebhook(){
        $body = json_decode($request->getContent(), true);
        // Handle webhook test
        if (in_array($body["data"]["description"], ["Ma giao dich thu nghiem", "VQRIO123"])) {
            return response()->json([
                "error" => 0,
                "message" => "Ok",
                "data" => $body["data"]
            ]);
        }

        // Check webhook data integrity 
        $PAYOS_CHECKSUM_KEY = env('PAYOS_CHECKSUM_KEY');
        $PAYOS_CLIENT_ID = env('PAYOS_CLIENT_ID');
        $PAYOS_API_KEY = env('PAYOS_API_KEY');

        $webhookData = $body["data"];
        $payOS = new PayOS($PAYOS_CLIENT_ID, $PAYOS_API_KEY, $PAYOS_CHECKSUM_KEY);
        $payOS->verifyPaymentWebhookData($webhookData);

        return response()->json([
            "error" => 0,
            "message" => "Ok",
            "data" => $webhookData
        ]);
    }

    private function filterData($request): array{
        $data = is_array($request) ? $request : $request->all();
        return array(
            'order_id' => $data['order_id'] ?? null,
            'amount' => $data['amount'] ?? null,
            'status' => $data['status'] ?? null,
            'payment_method' => $data['payment_method'] ?? null,
            'transaction_id' => $data['transaction_id'] ?? null
        );
    }
}
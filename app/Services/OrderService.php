<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Http\Resources\OrderResource;
use Illuminate\Validation\ValidationException;
use PayOS\PayOS;

class OrderService {
    protected $orderRepository, $payOSClientId, $payOSApiKey, $payOSChecksumKey;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
    )
    {
        $this->orderRepository = $orderRepository;

        $this->payOSClientId = env("PAYOS_CLIENT_ID");
        $this->payOSApiKey = env("PAYOS_API_KEY");
        $this->payOSChecksumKey = env("PAYOS_CHECKSUM_KEY");
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
        $orders = OrderResource::collection($orders)->resource;
        return $orders;
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
    
    public function createOrder($request)
    {
        $body = $request->input();
        $body["amount"] = intval($body["amount"]);
        $body["orderCode"] = intval(substr(strval(microtime(true) * 100000), -6));
        $payOS = new PayOS($this->payOSClientId, $this->payOSApiKey, $this->payOSChecksumKey);
        try {
            $response = $payOS->createPaymentLink($body);
            return response()->json([
                "error" => 0,
                "message" => "Success",
                "data" => $response["checkoutUrl"]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => $th->getCode(),
                "message" => $th->getMessage(),
                "data" => null
            ]);
        }
    }

    public function getPaymentLinkInfoOfOrder(string $id)
    {
        $payOS = new PayOS($this->payOSClientId, $this->payOSApiKey, $this->payOSChecksumKey);
        try {
            $response = $payOS->getPaymentLinkInfomation($id);
            return response()->json([
                "error" => 0,
                "message" => "Success",
                "data" => $response["data"]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => $th->getCode(),
                "message" => $th->getMessage(),
                "data" => null
            ]);
        }
    }

    public function cancelPaymentLinkOfOrder($request, string $id)
    {
        $body = json_decode($request->getContent(), true);
        $payOS = new PayOS($this->payOSClientId, $this->payOSApiKey, $this->payOSChecksumKey);
        try {
            $cancelBody = is_array($body) && $body["cancellationReason"] ? $body : null;
            $response = $payOS->cancelPaymentLink($id, $cancelBody);
            return response()->json([
                "error" => 0,
                "message" => "Success",
                "data" => $response["data"]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => $th->getCode(),
                "message" => $th->getMessage(),
                "data" => null
            ]);
        }
    }

    private function filterData($request): array{
        $data = is_array($request) ? $request : $request->all();
        return array(
            'user_id' => $data['user_id'] ?? null,
            'status' => $data['status'] ?? null,
            'total' => $data['total'] ?? null,
            'shipping_address' => $data['shipping_address'] ?? null,
            'payment_method' => $data['payment_method'] ?? null
        );
    }
}
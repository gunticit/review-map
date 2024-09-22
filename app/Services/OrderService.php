<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Http\Resources\OrderResource;
use Illuminate\Validation\ValidationException;

class OrderService {
    protected $orderRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
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
        $orders = OrderResource::collection($orders)->resource;
        $working = 0;
        $stopped = 0;
        foreach($orders as $order){
            if($order->status == 1){
                $working++;
            }
            if($order->status == 4){
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

    private function filterData($request): array{
        $data = is_array($request) ? $request : $request->all();
        return array(
            'name' => $data['name'] ?? null,
            'description' => $data['description'] ?? null,
            'package' => $data['package'] ?? null,
            'is_slow' => $data['is_slow'] ?? null,
            'point_slow' => $data['point_slow'] ?? null,
            'keyword' => $data['keyword'] ?? null,
            'latitude' => $data['latitude'] ?? null,
            'longitude' => $data['longitude'] ?? null,
            'place_id' => $data['place_id'] ?? null,
            'has_image' => $data['has_image'] ?? null,
            'address_google' => $data['address_google'] ?? null,
            'telephone_google' => $data['telephone_google'] ?? null,
            'rating_google' => $data['rating_google'] ?? null,
            'total_rating_google' => $data['total_rating_google'] ?? null,
            'rating_desire' => $data['rating_desire'] ?? null,
            'status' => $data['status'] ?? 1,
        );
    }
}
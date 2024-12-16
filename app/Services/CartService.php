<?php

namespace App\Services;
use App\Http\Resources\CartResource;
use App\Repositories\Cart\CartRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CartService {
    protected $cartRepository;

    public function __construct(
        CartRepositoryInterface $cartRepository,
    )
    {
        $this->cartRepository = $cartRepository;
    }
    public function store($request){
        $cart = $this->cartRepository->findByUserId(Auth::user()->id);
        if(!$cart){
            $data = $this->getData($request);
            $cart = $this->cartRepository->create($data);
        }
        $cart->products()->attach($request->product_id, ['quantity' => $request->quantity]);
    }

    public function update($request){
        $cart = $this->cartRepository->findByUserId($request->user_id);
        $cart->products()->updateExistingPivot($request->product_id, ['quantity' => $request->quantity]);
    }

    public function find($request){
        $cart = $this->cartRepository->findByUserId($request->user_id);
        return $cart;
    }

    public function findCartByUserIdAjax($request){
        $cart = $this->cartRepository->findCartByUserIdAjax($request);
        return new CartResource($cart);
    }

    private function getData($request){
        return [
            'user_id' => Auth::user()->id
        ];
    }
}
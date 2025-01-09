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
        if($request->user_id){
            $cart = $this->cartRepository->findByUserId($request->user_id);
        }elseif($request->cart_id){
            $cart = $this->cartRepository->find($request->cart_id);
        }
        $cart->products()->updateExistingPivot($request->product_id, ['quantity' => $request->quantity]);
    }

    public function find($request){
        $data_cart = array();
        if($request->user_id){
            $cart = $this->cartRepository->findByUserId($request->user_id);
        }elseif($request->cart_id){
            $cart = $this->cartRepository->find($request->cart_id);
        }
        if(empty($cart)) return null;
        $total = 0;
        if(empty($cart->products)) $total = 0;
        foreach($cart->products as $product){
            $total += $product->price * $product->pivot->quantity;
        }
        $data_cart = array(
            'id' => $cart->id,
            'user_id' => $cart->user_id,
            'products' => $cart->products,
            'user' => $cart->user,
            'total' => $total
        );
        return $data_cart;
    }

    public function findCartByUserIdAjax($request){
        $cart = $this->cartRepository->findCartByUserIdAjax($request);
        return new CartResource($cart);
    }

    public function remove($request){
        return $this->cartRepository->remove($request);
    }

    public function delete($id){
        return $this->cartRepository->delete($id);
    }

    private function getData($request){
        return [
            'user_id' => Auth::user()->id
        ];
    }
}
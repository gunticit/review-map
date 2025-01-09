<?php
namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Repositories\BaseRepository;

class CartRepository extends BaseRepository implements CartRepositoryInterface
{
    protected $model;

    public function __construct(Cart $cart)
    {
        $this->model = $cart;
    }
    public function find($id){
        $query = $this->model->query();
        $query = $query->with(['products'=> function($query){
            return $query->with(['images']);
        },'user']);
        $data = $query->where('id', $id)->first();
        return $data;
    }
    public function findByUserId($user_id){
        $query = $this->model->query();
        $query = $query->with(['products'=> function($query){
            return $query->with(['images']);
        },'user']);
        $data = $query->where('user_id', $user_id)->first();
        return $data; 
    }
    public function findCartByUserIdAjax($request){
        $query = $this->filterQuery($request);
        return $query->first();
    }
    public function filterQuery($request){
        $query = $this->query();
        $query = $query->with(['products']);
        if(isset($request->user_id)){
            $query->where('user_id', $request->user_id);
        }
        return $query;
    }
    public function remove($request)
    {
        $cart = $this->model->whereHas('cartProducts', function ($query) use ($request) {
            $query->where('product_id', $request->product_id)
                ->where('cart_id', $request->cart_id);
        })->first();

        if ($cart) {
            $cart->cartProducts()->where('product_id', $request->product_id)
                                ->where('cart_id', $request->cart_id)
                                ->delete();
            
            return true;
        }

        return false;
    }
}

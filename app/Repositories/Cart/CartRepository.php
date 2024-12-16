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
    public function findByUserId($user_id){
        return $this->model->where('user_id', $user_id)->first();
    }
    public function findCartByUserIdAjax($request){
        return $this->model->where('user_id', $user_id)->first();
    }
    public function filterData($request){
        $query = $this->query();
        $query = $query->with(['products']);
        if(isset($request->user_id)){
            $query->where('user_id', $request->user_id);
        }
        return $query;
    }
}

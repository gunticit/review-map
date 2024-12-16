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
        $query = $this->model->query();
        $query = $query->with(['products','user']);
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
}

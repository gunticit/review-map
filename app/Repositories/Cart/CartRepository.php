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
}

<?php
namespace App\Repositories\Cart;

interface CartRepositoryInterface
{
    public function findByUserId($user_id);
    public function findCartByUserIdAjax($request);
    public function filterQuery($request);
}

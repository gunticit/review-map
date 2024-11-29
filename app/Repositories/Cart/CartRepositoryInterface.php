<?php
namespace App\Repositories\Cart;

interface CartRepositoryInterface
{
    public function findByUserId($user_id);
}

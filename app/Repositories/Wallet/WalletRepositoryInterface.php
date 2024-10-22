<?php
namespace App\Repositories\Wallet;

interface WalletRepositoryInterface
{
    public function getBalance($request);
}

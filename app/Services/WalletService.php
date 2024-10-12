<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Repositories\Wallet\WalletRepositoryInterface;
use App\Repositories\TransactionHistory\TransactionHistoryRepositoryInterface;

class WalletService {
    protected $walletRepository;
    protected $transactionHistoryRepository;


    public function __construct(
        WalletRepositoryInterface $walletRepository,
        TransactionHistoryRepositoryInterface $transactionHistoryRepository
    )
    {
        $this->walletRepository = $walletRepository;
        $this->transactionHistoryRepository = $transactionHistoryRepository;
    }

    public function getBalance() {
        $user = Auth::user();
        $filter = array(
            'user_id' => $user->id
        );
        $balance = $this->walletRepository->getBalance($filter);
        return $balance;
    }

    public function getTransactionHistories(){
        $user = Auth::user();
        $wallet_id = $this->walletRepository->find($user->id);
        $filter = array(
            'user_id' => $user->id,
            'wallet_id' => $wallet_id
        );
        $transactionHistories = $this->transactionHistoryRepository->list($filter);
        return $transactionHistories;
    }
}
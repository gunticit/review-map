<?php

namespace App\Services;

use App\Enums\Status;
use App\Enums\TypeTransaction;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Wallet\WalletRepositoryInterface;
use App\Repositories\TransactionHistory\TransactionHistoryRepositoryInterface as TransactionHistoryRepository;

class WalletService
{
    protected $walletRepository;
    protected $transactionHistoryRepository;


    public function __construct(
        WalletRepositoryInterface $walletRepository,
        TransactionHistoryRepository $transactionHistoryRepository
    ) {
        $this->walletRepository = $walletRepository;
        $this->transactionHistoryRepository = $transactionHistoryRepository;
    }

    public function getBalance()
    {
        $user = Auth::user();
        $wallet = $this->walletRepository->findByKey('user_id', $user->id);
        $balance = $wallet ? $wallet->balance : 0;
        return $balance;
    }

    public function getTransactionHistories()
    {
        $user = Auth::user();
        $wallet = $this->walletRepository->findByKey('user_id', $user->id);
        if (!$wallet)
            return null;
        $transactionHistoriesQuery = $this->transactionHistoryRepository->findAllByKey('wallet_id', $wallet->id, 'desc');
        return $this->transactionHistoryRepository->pagination($transactionHistoriesQuery);
    }


    public function createWalletAndDeposit($amount, $reference_id)
    {
        DB::beginTransaction();
        try {
            $wallet = $this->checkWalletUser();
            $payload = [
                'wallet_id' => $wallet->id,
                'amount' => $amount ?? 0,
                'type' => TypeTransaction::DEPOSIT,
                'status' => Status::COMPLETED,
                'reference_id' => $reference_id,
            ];
            $transactionHistorie = $this->transactionHistoryRepository->create($payload);
            DB::commit();
            return $transactionHistorie;
        } catch (\Exception $e) {
            echo $e->getMessage() . $e->getCode();
            die();
            return false;
        }
    }

    public function updateWalletandTransactinon($amount, $reference_id)
    {
        DB::beginTransaction();
        try {
            $transactionHistorie = $this->createWalletAndDeposit($amount, $reference_id);
            if ($transactionHistorie->status == 'completed') {
                $wallet = $this->walletRepository->find($transactionHistorie->wallet_id);
                $wallet->balance = $wallet->balance + $transactionHistorie->amount;
                $wallet->save();
                DB::commit();
                return true;
            }
            return false;
        } catch (\Exception $e) {
            echo $e->getMessage() . $e->getCode();
            die();
            return false;
        }
    }
    private function checkWalletUser()
    {
        DB::beginTransaction();
        try {
            $user_id = Auth::user()->id;
            $wallet = $this->walletRepository->findByKey('user_id', $user_id);
            if (!$wallet) {
                $wallet = $this->walletRepository->create(['user_id' => $user_id]);
            }
            DB::commit();
            return $wallet;
        } catch (\Exception $e) {
            echo $e->getMessage() . $e->getCode();
            die();
            return false;
        }
    }

}
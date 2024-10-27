<?php

namespace App\Services;

use App\Enums\Status;
use App\Enums\TypeTransaction;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Wallet\WalletRepositoryInterface;
use App\Repositories\TransactionHistory\TransactionHistoryRepositoryInterface as TransactionHistoryRepository;
use Illuminate\Support\Facades\DB;

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
        if(empty($wallet)){
            $wallet = $this->walletRepository->create([
                'user_id' => $user->id,
                'provisional_deduction' => 0
            ]);
        }
        $transactionHistoriesQuery = $this->transactionHistoryRepository->findAllByKey('wallet_id', $wallet->id, 'desc');
        return $this->transactionHistoryRepository->pagination($transactionHistoriesQuery);
    }


    public function createWalletAndDeposit($amount, $reference_id)
    {
        try {
            DB::beginTransaction();
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
            throw $e;
        }
    }

    public function update($request, $id){
        try{
            DB::beginTransaction();
                $data = $this->filterData($request);
                $data = $this->walletRepository->update($data, $id);
            DB::commit();
            return $data;
        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function updateWalletandTransactinon($amount, $reference_id)
    {
        try {
            DB::beginTransaction();
                $transactionHistorie = $this->createWalletAndDeposit($amount, $reference_id);
                if ($transactionHistorie->status == 'completed') {
                        $wallet = $this->walletRepository->find($transactionHistorie->wallet_id);
                        $wallet->balance = $wallet->balance + $transactionHistorie->amount;
                        $wallet->save();
                    DB::commit();
                    return true;
                }
            DB::rollBack();
            return false;
        } catch (\Exception $e) {
            echo $e->getMessage() . $e->getCode();
            die();
            return false;
        }
    }
    public function checkWalletUser()
    {
        $user_id = Auth::user()->id;
        $wallet = $this->walletRepository->findByKey('user_id', $user_id);
        if (!$wallet) {
            $wallet = $this->walletRepository->create([
                'user_id' => $user_id
            ]);
        }
        return $wallet;
    }

    public function filterData($request){
        $data = array(
            'balance' => $request->balance ?? null,
            'user_id' => $request->user_id ?? null
        );
        return $data;
    }
}
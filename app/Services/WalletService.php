<?php

namespace App\Services;

use App\Exceptions\ProcessException;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Wallet\WalletRepositoryInterface;
use App\Repositories\TransactionHistory\TransactionHistoryRepositoryInterface;
use Illuminate\Support\Facades\DB;

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
    

    public function walletDeposit($request) {
        try{
            DB::beginTransaction();
                $user = Auth::user();
                $wallet_info = $this->walletRepository->findByKey('user_id', $user->id);
                $money = isset($request->money) ? parseCurrency($request->money) : 0;
                if(!empty($wallet_info)){
                    $balance = $wallet_info->balance;
                    if(!empty($money) && $money > 0){
                        $balance += (int)$money;
                        $data_update = array(
                            'user_id' => $user->id,
                            'balance' => $balance,
                        );
                        $wallet_info = $this->walletRepository->update($data_update,$wallet_info->id);
                        if($wallet_info){
                            $data_history = array(
                                'wallet_id' => $wallet_info->id,
                                'type' => 'deposit',
                                'amount' => $money,
                                'status' => 'completed', // Hiện tại gắn mặc định thành công, nào có api thanh toán thì theo trạng thái trả về của api
                                'payment_method_id' => 1, // Để tạm thời 1
                                'temp_balance' => $balance,
                                'reference_id' => null // Mã này lưu id transaction của api trả về
                            );
                            $this->addHistoryTransaction($data_history);
                        }
                    }
                }else{
                    if(!empty($money) && $money > 0){
                        $data_insert = array(
                            'user_id' => $user->id,
                            'balance' => $money,
                        );
                        $wallet_info = $this->walletRepository->create($data_insert);
                        if($wallet_info){
                            $data_history = array(
                                'wallet_id' => $wallet_info->id,
                                'type' => 'deposit',
                                'amount' => $money,
                                'status' => 'completed', // Hiện tại gắn mặc định thành công, nào có api thanh toán thì theo trạng thái trả về của api
                                'payment_method_id' => 1, // Để tạm thời 1
                                'temp_balance' => $money,
                                'reference_id' => null // Mã này lưu id transaction của api trả về
                            );
                            $this->addHistoryTransaction($data_history);
                        }
                    }
                }
            DB::commit();
            return $wallet_info;
        }catch(\Exception $e){
            DB::rollback();
            throw new ProcessException($e);
        }
    }

    protected function addHistoryTransaction($data = array()){
        if(!empty($data)){
            $this->transactionHistoryRepository->create($data);
        }
    }
}
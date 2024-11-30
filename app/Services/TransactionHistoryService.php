<?php

namespace App\Services;

use App\Repositories\TransactionHistory\TransactionHistoryRepositoryInterface;
use Illuminate\Validation\ValidationException;

class TransactionHistoryService {
    protected $transactionhistoryRepository;

    public function __construct(
        TransactionHistoryRepositoryInterface $transactionhistoryRepository,
    )
    {
        $this->transactionhistoryRepository = $transactionhistoryRepository;
    }

    /**
     * Authenticates the project with the given credentials.
     *
     * @param array $credentials The project's login credentials.
     * @return mixed|null The authenticated project if successful, null otherwise.
     * @throws ValidationException
     */

    public function list($request){
        return $this->transactionhistoryRepository->list($request);
    }

    public function fullList($request){
        $projects = $this->transactionhistoryRepository->list($request);
        return $projects;
    }

    public function create($request){
        $data = is_array($request) ? $request : $this->getData($request);
        $transactions = $this->transactionhistoryRepository->create($data);
        return $transactions;
    }
    
    public function find($id){
        return $this->transactionhistoryRepository->find($id);
    }

    public function wallet($id){
        return $this->transactionhistoryRepository->wallet($id);
    }

    public function listHistoriesByUser($user_id){
        return $this->transactionhistoryRepository->listHistoriesByUser($user_id);
    }

    public function totalMoneyHistoriesByField($request){
        return $this->transactionhistoryRepository->totalMoneyHistoriesByField($request);
    }
    public function getData($request){
        $data = array(
            'wallet_id' => $request->wallet_id,
            'type' => $request->type,
            'transaction_code' => $request->transaction_code ?? null,
            'amount' => $request->amount,
            'status' => $request->status,
            'payment_method_id' => $request->payment_method_id,
            'temp_balance' => $request->temp_balance,
            'reference_id' => $request->reference_id
        );
        return $data;
    }
}
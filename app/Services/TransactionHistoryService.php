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
        $transactions = $this->transactionhistoryRepository->create($request);
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
}
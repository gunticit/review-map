<?php
namespace App\Repositories\TransactionHistory;

interface TransactionHistoryRepositoryInterface
{
    public function list($request);
    public function fullList($request);
    public function listHistoriesByUser($user_id);
    public function totalMoneyHistoriesByField($request);
}

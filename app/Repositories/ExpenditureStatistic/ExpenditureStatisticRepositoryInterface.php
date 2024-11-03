<?php
namespace App\Repositories\ExpenditureStatistic;

interface ExpenditureStatisticRepositoryInterface
{
    public function list($request);
    public function expenditureByUser($request); // Chi tiêu của người dùng
    public function findByUser($filter = array());
    public function getAllExpenditureByUser($user_id);
    public function getMonthExpenditureByUser($user_id);
    public function getAllExpenditure();
}

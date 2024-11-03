<?php

namespace App\Services;

use App\Repositories\ExpenditureStatistic\ExpenditureStatisticRepositoryInterface;

class ExpenditureStatisticService
{
    protected $expenditureStatisticRepository;
    public function __construct(ExpenditureStatisticRepositoryInterface $expenditureStatisticRepository)
    {
        $this->expenditureStatisticRepository = $expenditureStatisticRepository;
    }

    public function create($request){
        $data = $this->expenditureStatisticRepository->create($request);
        return $data;
    }

    public function expenditureByUser($request){
        if(!$request->user_id){
            $request->merge(['user_id' => $request->user()->id]);
        }
        $data = $this->expenditureStatisticRepository->expenditureByUser($request);
        return $data;
    }

    public function updateExpenditureStatistic($data){
        $params = [
            'user_id' => $data['user_id'],
            'month' => $data['month']
        ];
        $expenditure_user = $this->expenditureStatisticRepository->findByUser($params);
        $expenditure_user_money = $expenditure_user->money ?? 0;
        $data['money'] = $expenditure_user_money + $data['money'];
        $data = $this->expenditureStatisticRepository->updateOrCreate($params,$data);
        return $data;
    }
    
    // Tổng số chi tiêu của người dung
    public function getAllExpenditureByUser($user_id){
        $data = $this->expenditureStatisticRepository->getAllExpenditureByUser($user_id);
        return $data;
    }

    // Tổng số chi tiêu theo từng tháng của người dùng
    public function getMonthExpenditureByUser($user_id){
        $data = $this->expenditureStatisticRepository->getMonthExpenditureByUser($user_id);
        return $data;
    }

    // Admin: Tổng số chi tiêu của khách hàng
    public function getAllExpenditure(){
        $data = $this->expenditureStatisticRepository->getAllExpenditure();
        return $data;
    }
}
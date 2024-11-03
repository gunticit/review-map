<?php
namespace App\Repositories\ExpenditureStatistic;

use App\Repositories\BaseRepository;
use App\Models\ExpenditureStatistic;
use App\Repositories\ExpenditureStatistic\ExpenditureStatisticRepositoryInterface;

class  ExpenditureStatisticRepository extends BaseRepository implements ExpenditureStatisticRepositoryInterface
{
    protected $model;

    public function __construct(ExpenditureStatistic $expenditureStatistic)
    {
        $this->model = $expenditureStatistic;
    }

    public function handleFilter($request){
        $query = $this->model->query();
        return $query;
    }

    public function list($request){
        $query = $this->handleFilter($request);
        $orderBy = $request->order_by ?? [];
        if(!empty($orderBy)){
            foreach ($orderBy as $column => $direction) {
                $query->orderBy($column, $direction);
            }
        }
        
        $page = $request->page ?? 1;
        $perPage = $request->per_page ?? 15;
        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    public function expenditureByUser($request){
        $query = $this->handleFilter($request);
        if($request->user_id){
            $query->where('user_id');
        }
        if($request->month){
            $query->whereMonth('month', $request->month);
        }
        if($request->year){
            $query->whereYear('month', $request->year);
        }
        return $query->first();
    }

    public function findByUser($filter = array()){
        return $this->model->where('user_id', $filter['user_id'])->where('month', $filter['month'])->first();
    }

    public function getAllExpenditureByUser($user_id){
        return $this->model->where('user_id', $user_id)->sum('money');
    }
    
    public function getMonthExpenditureByUser($user_id){
        return $this->model->where('user_id', $user_id)->select('month','money')->get()->pluck('money','month')->toArray();
    }

    public function getAllExpenditure(){
        $data = $this->model->selectRaw('month,sum(money) as money')->groupBy('month')->orderBy('month', 'desc')->get()->pluck('money','month')->toArray();
        return $data;
    }
}

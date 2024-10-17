<?php
namespace App\Repositories\Bank;

use App\Models\Bank;
use App\Repositories\BaseRepository;

class BankRepositoryRepository extends BaseRepository implements BankRepositoryInterface
{
    protected $model;



    public function __construct(Bank $bank)
    {
        $this->model = $bank;
    }

    public function list($request){
        $query = $this->model->query();
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

    public function countData($filter = array()){
        $query = $this->model->query();
        return $query->count();
    }
}

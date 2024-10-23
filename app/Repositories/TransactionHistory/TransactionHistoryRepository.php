<?php
namespace App\Repositories\TransactionHistory;

use App\Models\TransactionHistory;
use App\Repositories\BaseRepository;
use App\Repositories\TransactionHistory\TransactionHistoryRepositoryInterface;

class TransactionHistoryRepository extends BaseRepository implements TransactionHistoryRepositoryInterface
{
    protected $model;

    public function __construct(TransactionHistory $transactionHistory)
    {
        $this->model = $transactionHistory;
    }

    public function handleFilter(){
        $query = $this->model->query();
        return $query;
    }

    public function list($request){
        $query = $this->handleFilter();
        $query->with(['created_by','paymentMethod']);
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
}

<?php
namespace App\Repositories\Payment;

use App\Repositories\BaseRepository;
use App\Models\Payment;

class  PaymentRepository extends BaseRepository implements PaymentRepositoryInterface
{
    protected $model;

    public function __construct(Payment $order)
    {
        $this->model = $order;
    }

    public function list($request){
        $query = $this->model->query();
        if(isset($request->user_id)){
            $query->where('created_by', $request->user_id);
        }
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

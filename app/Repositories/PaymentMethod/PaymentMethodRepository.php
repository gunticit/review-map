<?php
namespace App\Repositories\PaymentMethod;

use App\Repositories\BaseRepository;
use App\Models\PaymentMethod;

class PaymentMethodRepository extends BaseRepository implements PaymentMethodRepositoryInterface
{
    protected $model;

    public function __construct(PaymentMethod $paymentMethod)
    {
        $this->model = $paymentMethod;
    }

    public function list($request){
        $query = $this->model->query()->with('created_by','parent');
        if(isset($request->user_id)){
            $query->where('created_by', $request->user_id);
        }
        if(isset($request->name)){
            $query->whereLike('name', '%'. $request->name . '%');
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

    public function countData($filter = array()){
        $query = $this->model->query();
        if(isset($filter['status'])){
            $query->where('status', $filter['status']);
        }
        return $query->count();
    }
}

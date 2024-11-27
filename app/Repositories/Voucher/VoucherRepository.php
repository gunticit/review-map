<?php
namespace App\Repositories\Voucher;

use App\Repositories\BaseRepository;
use App\Models\Voucher;

class  VoucherRepository extends BaseRepository implements VoucherRepositoryInterface
{
    protected $model;

    public function __construct(Voucher $category)
    {
        $this->model = $category;
    }

    public function list($request){
        $query = $this->model->query()->with('createdBy');
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

    public function checkAjaxApplyVoucher($voucher_code){
        $query = $this->model->query();
        $query->where('code', $voucher_code);
        $query->where('start_date', '<=', date('Y-m-d'));
        $query->where('end_date', '>=', date('Y-m-d'));
        $query->where('status', 'active');
        $query->whereRaw('max_uses >= uses_left + 1');
        return $query->first();
    }

    public function countDataGroupMonth($filter = array()){
        $query = $this->model->query();
        $filter['year'] = $filter['year'] ?? date('Y');
        if(isset($filter['status'])){
            $query->where('status', $filter['status']);
        }
        if(isset($filter['list_status'])){
            $query->whereIn('status', $filter['list_status']);
        }
        $query->where('created_at', 'like', $filter['year'] . '%');
        $query = $query->groupBy('created_at')->selectRaw('count(*) as total, TO_CHAR(created_at, \'MM\') as month');
        return $query->get();
    }
}

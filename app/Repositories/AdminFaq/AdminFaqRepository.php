<?php
namespace App\Repositories\AdminFaq;

use App\Repositories\BaseRepository;
use App\Models\Faq;

class  AdminFaqRepository extends BaseRepository implements AdminFaqRepositoryInterface
{
    protected $model;

    public function __construct(Faq $category)
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
        }else{
            $query->orderBy('created_at', 'desc');
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
        $query = $query->groupByRaw('TO_CHAR(created_at, \'MM\')')
                   ->selectRaw('count(*) as total, TO_CHAR(created_at, \'MM\') as month');
        return $query->get();
    }
}

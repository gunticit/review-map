<?php
namespace App\Repositories\CensorshipHistory;

use App\Models\CensorshipHistory;
use App\Repositories\BaseRepository;

class CensorshipHistoryRepository extends BaseRepository implements CensorshipHistoryRepositoryInterface
{
    protected $model;

    public function __construct(CensorshipHistory $censorshipHistory)
    {
        $this->model = $censorshipHistory;
    }
    public function list($request){
        $query = $this->model->newQuery();
        $this->handleFilter($query, $request);
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
    public function getAll($request){
        $query = $this->model->newQuery();
        $this->handleFilter($query, $request);
        $orderBy = $request->order_by ?? [];
        if(!empty($orderBy)){
            foreach ($orderBy as $column => $direction) {
                $query->orderBy($column, $direction);
            }
        }
        return $query->get();
    }
    public function handleFilter($query, $request){
        if($request->approver_id){
            $query->where('approver_id', $request->approver_id);
        }
        if($request->partner_id){
            $query->where('partner_id', $request->partner_id);
        }
        if($request->mission_id){
            $query->where('mission_id', $request->mission_id);
        }
    }
}

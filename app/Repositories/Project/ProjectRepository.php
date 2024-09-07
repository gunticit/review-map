<?php
namespace App\Repositories\Project;

use App\Repositories\BaseRepository;
use App\Models\Project;

class  ProjectRepository extends BaseRepository implements ProjectRepositoryInterface
{
    protected $model;

    public function __construct(Project $project)
    {
        $this->model = $project;
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
        $query = $query->groupBy('created_at')->selectRaw('count(*) as total, DATE_FORMAT(created_at, "%m") as month');
        return $query->get();
    }
}

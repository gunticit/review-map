<?php
namespace App\Repositories\Project;

use App\Repositories\BaseRepository;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ProjectOrderRepository extends BaseRepository implements ProjectOrderRepositoryInterface
{
    protected $model;

    public function __construct(Project $project)
    {
        $this->model = $project;
    }

    public function list($request){
        $query = $this->model->query();
        if(isset($request->user_id) && Auth::user()->getRoleNames()->first() != 'admin'){
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

    public function wrongImages($id){
        $this->model->where('id', $id)->update(['is_wrong_image' => 1]);
    }

    public function find($id)
    {
        return $this->model->with('images')->find($id);
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

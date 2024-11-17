<?php
namespace App\Repositories\Project;

use App\Repositories\BaseRepository;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class  ProjectRepository extends BaseRepository implements ProjectRepositoryInterface
{
    protected $model;

    public function __construct(Project $project)
    {
        $this->model = $project;
    }

    public function handleFilter($request){
        $query = $this->model->query();
        if(isset($request->user_id) && Auth::user()->getRoleNames()->first() != 'admin'){
            $query->where('created_by', $request->user_id);
        }
        if(isset($request->status)){
            $query->where('status', $request->status);
        }
        if(isset($request->name)){
            $query->whereLike('name', '%'. $request->name . '%');
        }
        if(isset($request->year)){
            $query->whereYear('created_at', $request->year);
        }
        return $query;
    }

    public function list($request){
        $query = $this->handleFilter($request);
        $query = $query->with(['missions' => function($query){
            $query->with('comments');
        }]);
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
        if(isset($filter['year'])){
            $query->whereYear('created_at', $filter['year']);
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

    public function findWithComments($project_id, $request){
        $query = $this->model->query();
        $query->with('comments');
        $query->where('id', $project_id);
        return $query->first();
    }

    public function countDataGroupMonth($filter = array()) {
        $query = $this->model->query();
        $filter['year'] = $filter['year'] ?? date('Y');
    
        // Apply filters
        if (isset($filter['status'])) {
            $query->where('status', $filter['status']);
        }
        if (isset($filter['list_status'])) {
            $query->whereIn('status', $filter['list_status']);
        }
    
        // Filter by year
        $query->whereYear('created_at', $filter['year']);
    
        // Detect current database driver (MySQL or PostgreSQL)
        $driver = DB::getDriverName();
    
        if ($driver === 'pgsql') {
            // PostgreSQL: Use TO_CHAR to format the month
            $query->groupBy(DB::raw("TO_CHAR(created_at, 'MM')"))
                  ->selectRaw("count(*) as total, TO_CHAR(created_at, 'MM') as month");
        } else {
            // MySQL: Use DATE_FORMAT to format the month
            $query->groupBy(DB::raw("DATE_FORMAT(created_at, '%m')"))
                  ->selectRaw("count(*) as total, DATE_FORMAT(created_at, '%m') as month");
        }
    
        return $query->get();
    }
    
    public function totalPrice($filter = array()) {
        $query = $this->model->query();
        $filter['year'] = $filter['year'] ?? date('Y');
        $query->whereYear('created_at', $filter['year']);
        return $query->sum('price');
    }
}

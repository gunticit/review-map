<?php
namespace App\Repositories;
 
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\RepositoryInterface;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
class BaseRepository implements RepositoryInterface
{
    // model property on class instances
    protected $model;
 
    # Khai báo các trường muốn tìm kiếm like cho biến keyword (ở các Repository thừa kế)
    protected $filterLikeKeys = [];
    # Khai báo các trường muốn tìm kiếm bằng (ở các Repository thừa kế)
    protected $filterEqualKeys = [];
 
    // Constructor to bind model to repo
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
 
    // Get all instances of model
    public function all()
    {
        return $this->model->all();
    }
 
    // Create a new record in the database
    public function create(array $data)
    {
 
        $data = $this->model->create($data);
        return $data->fresh();
    }
 
    // Update record in the database
    public function update(array $data, $id)
    {
        $model = $this->model->find($id);
        $model->update($data);
 
        return $model;
    }
 
    // Remove record from the database
    public function delete($id)
    {
        $this->model->destroy($id);
        return $this->model->fresh();
    }
 
    // Find the record with the given id
    public function find($id)
    {
        return $this->model->find($id);
    }
 
    // Find the record with the given id
    public function findByKey($key, $value, $columns = ['*'], $with = [], $option = '') {
        if($option == 'all'){
            return $this->model->select($columns)->where($key, $value)->get();
        }
        return $this->model->select($columns)->where($key, $value)->first();
    }
 
    // Show the record with the given id
    public function show($id)
    {
        return $this->model->findOrFail($id);
    }
 
    // Get list pagination instances of model
    public function pagination($query, $columns = array('*'))
    {
        $perPage = request()->input('per_page') ?? config('constants.per_page');
        $page = request()->input('page') ?? config('constants.page');
        return $query->paginate($perPage, $columns, 'page', $page);
    }
 
    // Get list instances of model for condition
    public function filter($columns = array('*'), $orderBy = array('id' => 'asc'))
    {
        $query = $this->model->select($columns);
        if (!empty($orderBy)) {
            foreach ($orderBy as $key => $order) {
                $query->orderBy($key, $order);
            }
        }
 
        return $query->get();
    }
 
    public function bulkDelete($ids = [])
    {
        $this->model->query()->whereIn('id', $ids)->delete();
 
        return $this->model->fresh();
    }

    public function deleteByKey($key, $value)
    {
        $this->model->query()->where($key, $value)->delete();
 
        return $this->model->fresh();
    }
 
    // Create a new record in the database and get back the ID
    public function insertGetId(array $data)
    {
        return $this->model->insertGetId($data);
    }
 
    // Update Or Create new record in the database
    public function updateOrCreate(array $params, array $data)
    {
        return $this->model->updateOrCreate($params, $data);
    }
 
    /**
     * Filter conditions.
     * Structure
     * [ 'column' => 'columnFilter', 'operator' => 'typeOperator', 'value' => 'valueFilter' ]
     */
    public function filterConditions($query, array $filterConditions = [])
    {
        foreach ($filterConditions as $condition)
        {
            $query = $query->where($condition['column'], $condition['operator'], $condition['value']);
        }
 
        return $query;
    }
 
    public function filterWhereIn($query, $column, $values)
    {
        if (!empty($values)) {
            $values = explode(',', $values);
            $query->whereIn($column, $values);
        }
    }
 
    public function filterWhereHasIn($query, $relation, $column, $values)
    {
        if (!empty($values)) {
            $values = explode(',', $values);
            $query->whereHas($relation, function ($q) use ($column, $values) {
                $q->whereIn($column, $values);
            });
        }
    }
 
    public function filterDateRange($query, $column, $from, $to)
    {
        if(!empty($from) || !empty($to)) {
            $from = Carbon::parse($from)->startOfDay();
            $to = Carbon::parse($to)->endOfDay();
            $query->whereBetween($column, [$from, $to]);
        }
    }
 
    public function query()
    {
        return $this->model->query();
    }
 
    public function orderBy($query, $orderBy = array('id' => 'asc'))
    {
        if (!empty($orderBy)) {
            foreach ($orderBy as $column => $direction) {
                $query->orderBy($column, $direction);
            }
        }
    }
 
    # Hàm hỗ trợ lọc data theo một số chức năng cơ bản
    public function filterData($query, $request){
        $keyword = $request->keyword ?? '';
        $params = $request->all();
 
        if ($keyword !== '') {
            $query = $query->where(function ($query) use ($keyword) {
                foreach ($this->filterLikeKeys as $column) {
                    $query = $query->orWhere($column, 'LIKE', '%' . $keyword . '%');
                }
            });
        }
 
        if (!empty($this->filterLikeKeys)) {
            foreach ($this->filterLikeKeys as $column) {
                $query = $query->where(function ($query) use ($column, $params) {
                    if (!empty($params[$column])) {
                        $query = $query->orWhere($column, 'LIKE', '%' . $params[$column] . '%');
                    }
                });
            }
        }
 
        if (!empty($this->filterEqualKeys)) {
            foreach ($this->filterEqualKeys as $column) {
                $query = $query->where(function ($query) use ($column, $params) {
                    if (!empty($params[$column])) {
                        $query = $query->orWhere($column, $params[$column]);
                    }
                });
            }
        }
 
        return $query;
    }
 
    // Insert array in the database
    public function insert(array $data)
    {
        if($data !== null && count($data) > 0)
        {
            try {
                return $this->model->insert($data);
            }
            catch(\Exception $e){
                throw $e;
            }
        }
    }
 
    public function getStatusCountsRaw($statuses)
    {
        $selectStatements = [];
        $selectStatements[] = "COUNT(*) as all";
        foreach ($statuses as $status) {
            $selectStatements[] = "SUM(CASE WHEN status = '{$status}' THEN 1 ELSE 0 END) as {$status}";
        }
 
        return implode(', ', $selectStatements);
    }

    public function findWith($data, $columns = 'id'){
        $columns = explode('|', $columns);
        $query = $this->model->query();
        foreach($columns as $column){
            if(isset($data[$column])){
                $query = $query->where($column, $data[$column]);
            }
        }
        return $query->first();
    }

    public function findAllByKey($column, $value, $orderBy = 'asc')
    {
        return $this->model->where($column, $value)->orderBy('id', $orderBy); 
    }
}
<?php
namespace App\Repositories\Guarantee;

use App\Repositories\BaseRepository;
use App\Models\Guarantee;
use App\Repositories\Guarantee\GuaranteeSupportRepositoryInterface;

class  GuaranteeSupportRepository extends BaseRepository implements GuaranteeSupportRepositoryInterface
{
    protected $model;


    public function __construct(Guarantee $guarantee)
    {
        $this->model = $guarantee;
    }

    public function list($request){
        $query = $this->model->query();
        
        $orderBy = $request->order_by ?? [];
        if(!empty($orderBy)){
            foreach ($orderBy as $column => $direction) {
                $query->orderBy($column, $direction);
            }
        }
        
        $page = $request->page ?? 1;
        $perPage = $request->per_page ?? 15;
        $query = $query->with(['department']);
        return $query->paginate($perPage, ['*'], 'page', $page);
    }
}

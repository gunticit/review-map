<?php
namespace App\Repositories\Support;

use App\Repositories\BaseRepository;
use App\Models\Support;
use App\Repositories\Support\SupportRepositoryInterface;

class  SupportRepository extends BaseRepository implements SupportRepositoryInterface
{
    protected $model;

    public function __construct(Support $support)
    {
        $this->model = $support;
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

<?php
namespace App\Repositories\Profile;

use App\Repositories\BaseRepository;
use App\Models\User;
use App\Repositories\Profile\ProfileRepositoryInterface;

class  ProfileRepository extends BaseRepository implements ProfileRepositoryInterface
{
    protected $model;

    public function __construct(User $project)
    {
        $this->model = $project;
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
        return $query->paginate($perPage, ['*'], 'page', $page);
    }
}

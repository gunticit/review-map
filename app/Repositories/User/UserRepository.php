<?php
namespace App\Repositories\User;

use App\Repositories\BaseRepository;
use App\Models\User;

class  UserRepository extends BaseRepository implements UserRepositoryInterface
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
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

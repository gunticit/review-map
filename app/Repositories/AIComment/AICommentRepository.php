<?php
namespace App\Repositories\AIComment;

use App\Repositories\BaseRepository;
use App\Models\AIComment;

class  AIMessageRepository extends BaseRepository implements AICommentRepositoryInterface
{
    protected $model;

    public function __construct(AIComment $aiComment)
    {
        $this->model = $aiComment;
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

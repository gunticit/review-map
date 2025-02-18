<?php
namespace App\Repositories\Comment;

use App\Repositories\BaseRepository;
use App\Models\Comment;
use App\Repositories\Comment\CommentRepositoryInterface;

class  CommentRepository extends BaseRepository implements CommentRepositoryInterface
{
    protected $model;


    public function __construct(Comment $comment)
    {
        $this->model = $comment;
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


    public function deleteByKeyLimit($key, $value, $limit = null, $column = null)
    {
        $query = $this->model->query()->where($key, $value);
        if (!is_null($column)) {
            $query->where(function ($query) use ($column) {
                $query->whereNull($column)->orWhere($column, '=', '');
            });
        }
        if (!is_null($limit)) {
            $query->limit($limit);
        }
        $query->delete();
 
        return $this->model->fresh();
    }
}

<?php
namespace App\Repositories\History;

use App\Repositories\BaseRepository;
use App\Models\History;
use App\Repositories\History\HistoryRepositoryInterface;

class  HistoryRepository extends BaseRepository implements HistoryRepositoryInterface
{
    protected $model;

    public function __construct(History $history)
    {
        $this->model = $history;
    }

    public function list($request){
        $query = $this->model->query();
        if(!empty($request->keyword)){
            $keyword = $request->keyword;
            $query = $query->where(function ($query) use ($keyword) {
                $query->whereRaw("LOWER(content->>'$.title') LIKE ?", ['%' . strtolower($keyword) . '%'])
                      ->orWhereRaw("LOWER(content->>'$.content') LIKE ?", ['%' . strtolower($keyword) . '%']);
            });
        }
        if(!empty($request->date)){
            $query = $query->whereDate('created_at', urldecode($request->date));
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
}

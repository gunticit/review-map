<?php
namespace App\Repositories\History;

use App\Repositories\BaseRepository;
use App\Models\History;
use App\Repositories\History\HistoryRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class  HistoryRepository extends BaseRepository implements HistoryRepositoryInterface
{
    protected $model;

    public function __construct(History $history)
    {
        $this->model = $history;
    }

    public function list($request){
        $query = $this->model->query();
        $user_id = Auth::user()->id;
        $query->where('user_id', $user_id);
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

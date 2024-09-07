<?php
namespace App\Repositories\Faq;

use App\Repositories\BaseRepository;
use App\Models\Faq;

class  FaqRepository extends BaseRepository implements FaqRepositoryInterface
{
    protected $model;

    public function __construct(Faq $faq)
    {
        $this->model = $faq;
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

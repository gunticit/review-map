<?php
namespace App\Repositories\ProductImage;

use App\Repositories\BaseRepository;
use App\Models\ProductImage;

class  ProductImageRepository extends BaseRepository implements ProductImageRepositoryInterface
{
    protected $model;

    public function __construct(ProductImage $project)
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

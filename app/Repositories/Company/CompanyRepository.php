<?php
namespace App\Repositories\Company;

use App\Models\Company;
use App\Repositories\BaseRepository;
use App\Repositories\Company\CompanyRepositoryInterface;

class  CompanyRepository extends BaseRepository implements CompanyRepositoryInterface
{
    protected $model;

    public function __construct(Company $project)
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

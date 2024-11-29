<?php
namespace App\Repositories\ProjectImage;

use App\Repositories\BaseRepository;
use App\Models\ProjectImage;

class  ProjectImageRepository extends BaseRepository implements ProjectImageRepositoryInterface
{
    protected $model;

    public function __construct(ProjectImage $project)
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
    public function findImageByProject($project_id){
        $query = $this->model->query();
        $query = $query->where('project_id', $project_id);
        $query = $query->first();
        return $query;
    }
}

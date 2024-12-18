<?php
namespace App\Repositories\Setting;

use App\Repositories\BaseRepository;
use App\Models\Setting;

class  SettingRepository extends BaseRepository implements SettingRepositoryInterface
{
    protected $model;

    public function __construct(Setting $setting)
    {
        $this->model = $setting;
    }

    public function list($request){
        $query = $this->model->query()->with('createdBy');
        if(isset($request->user_id)){
            $query->where('created_by', $request->user_id);
        }
        if(isset($request->name)){
            $query->whereLike('name', '%'. $request->name . '%');
        }
        $orderBy = $request->order_by ?? [];
        if(!empty($orderBy)){
            foreach ($orderBy as $column => $direction) {
                $query->orderBy($column, $direction);
            }
        }else{
            $query->orderBy('created_at', 'desc');
        }
        
        $page = $request->page ?? 1;
        $perPage = $request->per_page ?? 15;
        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    public function findSettingByKey($keyword){
        return $this->model->where('key_setting', $keyword)->first();
    }
}

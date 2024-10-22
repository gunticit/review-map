<?php
namespace App\Repositories\Mission;

use App\Repositories\BaseRepository;
use App\Models\Mission;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class  MissionRepository extends BaseRepository implements MissionRepositoryInterface
{
    protected $model;

    public function __construct(Mission $mission)
    {
        $this->model = $mission;
    }

    public function handleFilter($request){
        $query = $this->model->query();
        if(Auth::user()->getRoleNames()->first() == 'admin'){
            // Nếu là Role Admin thì user nào tạo user đó thấy 
            $query->where('created_by', $request->user_id);
        }else if(Auth::user()->getRoleNames()->first() == 'partner'){
            // Nếu là Role Đối tác nhiệm vụ của ai người đó thấy
            $query->where('user_id', Auth::user()->id);
        } else {
            // Còn lại Role KHách hàng thì dựa theo project id
        }
        return $query;
    }

    public function list($request){
        $query = $this->handleFilter($request);
        $query->with(['comments','project', 'images']);
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

    public function find($id){
        $query = $this->model->query();
        $query->with(['comments','project', 'images']);
        $query->where('id', $id);
        return $query->first();
    }

    public function getRandomMission($request){
        if(isset($request->user_id) && Auth::user()->getRoleNames()->first() === 'partner'){
            $query = $this->model->query();
            $query->where('user_id', $request->user_id)->where('status',2);
            $check_mission = $query->first();
            if($check_mission){
                return $check_mission;
            }

            $projects = Project::all();

            foreach ($projects as $project) {
                $totalMissions = Mission::where('project_id', $project->id)->count();
                $maxMissions = 0;
                switch ($project->package) {
                    case 1:
                        $maxMissions = 10;
                        break;
                    case 2:
                        $maxMissions = 50;
                        break;
                    case 3:
                        $maxMissions = 100;
                        break;
                    case 4:
                        $maxMissions = 200;
                        break;
                }

                if ($totalMissions < $maxMissions) {
                    $missionsToday = Mission::where('project_id', $project->id)
                                            ->whereDate('created_at', now()->format('Y-m-d'))
                                            ->count();

                    if ($missionsToday < $project->point_slow) {
                        $newMission = Mission::create([
                            'user_id' => $userId,
                            'project_id' => $project->id,
                            'status' => 2, 
                            'created_by' => $userId,
                        ]);

                        return $newMission;
                    }
                }
            }
            return null;

        }
    }

}

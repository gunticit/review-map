<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Repositories\Project\ProjectRepositoryInterface;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Traits\PusherTrait;
use Illuminate\Validation\ValidationException;

class ProjectService {
    use PusherTrait;
    protected $projectRepository;

    public function __construct(
        ProjectRepositoryInterface $projectRepository,
    )
    {
        $this->projectRepository = $projectRepository;
    }

    /**
     * Authenticates the project with the given credentials.
     *
     * @param array $credentials The project's login credentials.
     * @return mixed|null The authenticated project if successful, null otherwise.
     * @throws ValidationException
     */

    public function list($request){
        $request = $request->merge([
            'user_id' => isset($request->user_id) ? $request->user_id : Auth::user()->id,
            'order_by' => array('created_at' => 'desc')
        ]);
        $total_projects = $this->projectRepository->countData($request);
        $projects = $this->projectRepository->list($request);
        $projects = ProjectResource::collection($projects)->resource;
        $all_price_projects = $this->projectRepository->totalPrice($request);
        $working = 0;
        $stopped = 0;
        $unpaid = 0;
        foreach($projects as $project){
            if($project->status == Project::WORKING_PROJECT){
                $working++;
            }
            if($project->status == Project::STOPPED_PROJECT){
                $stopped++;
            }
            if($project->status == 5){
                $unpaid++;
            }
        }
        $data = array(
            'projects' => $projects,
            'total' => $total_projects,
            'working' => $working,
            'stopped' => $stopped,
            'all_price_projects' => $all_price_projects,
            'unpaid' => $unpaid
        );
        return $data;
    }

    public function fullList($request){
        $projects = $this->projectRepository->list($request);
        return $projects;
    }

    public function create($request){
        $project = $this->filterData($request);
        $data = $this->projectRepository->create($project);
        return $data;
    }

    public function show($id){
        $query = $this->projectRepository->query();
        $query = $query->with(['missions' => function($query){
            $query->with('comments');
        }]);
        $data = $query->find($id);
        return $data;
    }

    public function update($request, $id){
        $project = $this->filterData($request);
        $data = $this->projectRepository->update($project, $id);
        return $data; 
    }

    public function wrongImages($id){
        $data = $this->projectRepository->wrongImages($id);
        return $data;
    }

    public function sendNotification($data = array(
        'message' => '',
    ))
    {
        $this->triggerEvent('notify-channel', 'notify-event', $data);
        return response()->json(['status' => 'Notification sent!']);
    }

    public function findWithComments($project_id, $request){
        $data = $this->projectRepository->findWithComments($project_id, $request);
        return $data;
    }

    public function updateStatus($request, $id){
        $data = [
            'status' => $request->status
        ];
        $data = $this->projectRepository->update($data, $id);
        return $data;
    }

    public function updateOrderProject($project_id){
        // Xử lý api thanh toán 
        // Xử lý lưu transaction
        // Cập nhật lại trạng thái project từ chưa thanh toán sang đang hoạt động
        $data = array(
            'status' => 1,
        );
        $data = $this->projectRepository->update($data,$project_id);
        return $data;
    }

    public function destroyByIds($request){
        $ids = $request->ids;
        if(count($ids) == 0){
            throw new \Exception("Bạn phải chọn ít nhất một dự án để xóa");
        }
        $ids = $request->ids;
        $data = $this->projectRepository->destroyByIds($ids);
        return $data;
    }

    private function filterData($request): array{
        $data = is_array($request) ? $request : $request->all();
        return array(
            'name' => $data['name'] ?? null,
            'project_code' => $data['project_code'] ?? null,
            'description' => $data['description'] ?? null,
            'package' => $data['package'] ?? null,
            'is_slow' => $data['is_slow'] ?? null,
            'point_slow' => $data['point_slow'] ?? null,
            'keyword' => $data['keyword'] ?? null,
            'latitude' => $data['latitude'] ?? null,
            'longitude' => $data['longitude'] ?? null,
            'place_id' => $data['place_id'] ?? null,
            'has_image' => $data['has_image'] ?? null,
            'address_google' => $data['address_google'] ?? null,
            'telephone_google' => $data['telephone_google'] ?? null,
            'rating_google' => $data['rating_google'] ?? null,
            'total_rating_google' => $data['total_rating_google'] ?? null,
            'rating_desire' => $data['rating_desire'] ?? null,
            'status' => $data['status'] ?? 5,
        );
    }
}
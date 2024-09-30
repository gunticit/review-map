<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Repositories\Project\ProjectOrderRepository;
use App\Http\Resources\ProjectResource;
use App\Traits\PusherTrait;
use Illuminate\Validation\ValidationException;

class ProjectOrderService {
    use PusherTrait;
    protected $projectOrderRepository;

    public function __construct(
        ProjectOrderRepository $projectOrderRepository,
    )
    {
        $this->projectOrderRepository = $projectOrderRepository;
    }

    /**
     * Authenticates the project with the given credentials.
     *
     * @param array $credentials The project's login credentials.
     * @return mixed|null The authenticated project if successful, null otherwise.
     * @throws ValidationException
     */

    public function list($request){
        $request = $request->merge(['user_id' => Auth::user()->id]);
        $projectOrders = $this->projectOrderRepository->list($request);
        $data = array(
            'projectOrders' => $projectOrders,
            'total' => count($projectOrders),
        );
        return $data;
    }

    public function fullList($request){
        $projects = $this->projectOrderRepository->list($request);
        return $projects;
    }

    public function create($request){
        $project = $this->filterData($request);
        $data = $this->projectOrderRepository->create($project);
        return $data;
    }

    public function show($id){
        $data = $this->projectOrderRepository->find($id);
        return $data;
    }

    public function update($request, $id){
        $project = $this->filterData($request);
        $data = $this->projectOrderRepository->update($project, $id);
        return $data; 
    }

    public function wrongImages($id){
        $data = $this->projectOrderRepository->wrongImages($id);
        return $data;
    }

    public function sendNotification($data = array(
        'message' => '',
    ))
    {
        $this->triggerEvent('notify-channel', 'notify-event', $data);
        return response()->json(['status' => 'Notification sent!']);
    }

    private function filterData($request): array{
        $data = is_array($request) ? $request : $request->all();
        return array(
            'name' => $data['name'] ?? null,
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
            'status' => $data['status'] ?? 1,
        );
    }
}
<?php

namespace App\Services;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Support\SupportRepositoryInterface;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\SupportResource;
use App\Models\Support;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class SupportService {
    protected $supportRepository;

    public function __construct(SupportRepositoryInterface $supportRepository)
    {
        $this->supportRepository = $supportRepository;
    }

    /**
     * Authenticates the project with the given credentials.
     *
     * @param array $credentials The project's login credentials.
     * @return mixed|null The authenticated project if successful, null otherwise.
     * @throws ValidationException
     */

    public function listCreateByUser($request){
        $request = $request->merge(['user_id' => Auth::user()->id]);
        $supports = $this->supportRepository->listCreateByUser($request);
        $data = SupportResource::collection($supports)->resource;
        return $data;
    }

    public function create($request){
        try{
            $data = $this->filterData($request);
            $file_path = $this->uploadImage($request);
            $data['filepath'] = implode('|', $file_path);
            $data['status'] = Support::INCOMPLETE_SUPPORT; // Đang xử lý
            $data['support_code'] = Support::generateSupportCode();
            $data = $this->supportRepository->create($data);
            return $data;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function show($id){
        $data = $this->supportRepository->find($id);
        return $data;
    }

    public function update($request, $id){
        $data = $this->filterData($request);
        $data = $this->supportRepository->update($data, $id);
        return $data; 
    }

    public function uploadImage($request){
        $data = array();
        $project_id = $request->project_id ?? 'undefined'; 
        if ($request->hasFile('files')) {
            $folder = 'uploads' . '/supports/' . date('Y-m') . '/' . date('d') . '/' . $project_id;
            foreach ($request->file('files') as $image) {
                $path = $image->store($folder, 'public');
                $data[] = $path;
            }
        }
        return $data;
    }

    private function filterData($request): array{
        $data = $request->all();
        return array(
            'title' => $data['title'] ?? null,
            'department_id' => $data['department_id'] ?? null,
            'project_id' => $data['project_id'] ?? null,
            'content' => $data['content'] ?? null,
            'status' => $data['status'] ?? null
        );
    }
}
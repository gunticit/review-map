<?php
namespace App\Repositories\Notification;

use App\Repositories\BaseRepository;
use App\Models\Notification;
use App\Repositories\Notification\NotificationRepositoryInterface;

class  NotificationRepository extends BaseRepository implements NotificationRepositoryInterface
{
    protected $model;

    public function __construct(Notification $notification)
    {
        $this->model = $notification;
    }

    public function list($request){
        $query = $this->model->query();

        $user_ids = $request->user_ids ?? [];
        if(!empty($user_ids)){
            $query->whereIn('user_id', $user_ids);
        }

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


    public function listByGroupTitle($request)
    {
        // Bắt đầu query chính
        $query = $this->model->query();

        // Lọc theo user_id nếu có
        $user_ids = $request->user_ids ?? [];
        if (!empty($user_ids)) {
            $query->whereIn('user_id', $user_ids);
        }

        // Nhóm theo `title` và chỉ lấy `id` nhỏ nhất cho mỗi `title` (lấy bản ghi đầu tiên cho mỗi nhóm)
        $query->select(\DB::raw('MIN(id) as id'), 'title')
            ->groupBy('title')
            ->havingRaw('COUNT(id) > 0');

        // Lấy các id của các bản ghi đầu tiên của từng `title` từ query trên
        $ids = $query->pluck('id');

        // Sử dụng các `id` này để lấy dữ liệu đầy đủ cho mỗi bản ghi tương ứng
        $mainQuery = $this->model->whereIn('id', $ids);

        // Sắp xếp nếu có yêu cầu
        $orderBy = $request->order_by ?? [];
        if (!empty($orderBy) && is_array($orderBy)) {
            foreach ($orderBy as $column => $direction) {
                $direction = strtolower($direction) === 'desc' ? 'desc' : 'asc';
                $mainQuery->orderBy($column, $direction);
            }
        }

        // Phân trang
        $page = $request->page ?? 1;
        $perPage = $request->per_page ?? 15;

        return $mainQuery->paginate($perPage, ['*'], 'page', $page);
    }

    public function markAsRead($id){
        $this->model->where('id', $id)->update(['read_at' => now()]);
    }
}

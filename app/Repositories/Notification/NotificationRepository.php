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

    public function markAsRead($id){
        $this->model->where('id', $id)->update(['read_at' => now()]);
    }
}

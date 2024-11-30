<?php
namespace App\Repositories\CensorshipHistory;

use App\Models\CensorshipHistory;
use App\Repositories\BaseRepository;

class CensorshipHistoryRepository extends BaseRepository implements CensorshipHistoryRepositoryInterface
{
    protected $model;

    public function __construct(CensorshipHistory $censorshipHistory)
    {
        $this->model = $censorshipHistory;
    }
}

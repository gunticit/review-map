<?php
namespace App\Services;

use App\Models\User;
use App\Models\Level;

class LevelService
{
    public function updateUserLevel(User $user)
    {
        // Lấy danh sách các cấp độ theo thứ tự tăng dần
        $levels = Level::orderBy('required_tasks', 'asc')->get();

        foreach ($levels as $level) {
            if ($user->tasks_completed >= $level->required_tasks) {
                $user->level = $level->id;
            } else {
                break;
            }
        }

        $user->save();
    }
}
?>
<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Project;

class ChangeStatusCompletedProjectJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        \Log::info('ChangeStatusCompletedProjectJob:  START '.date('Y-m-d H:i:s'));
        //Cập nhật trạng thái dự án
        $project = Project::where('status', Project::WORKING_PROJECT)->withCount('missionsCompleted')->get()->toArray();
        foreach ($project as $item) {
            $totalMission = 0;
            switch($item['package']) {
                case '1':
                    $totalMission = 10;
                    break;
                case '2':
                    $totalMission = 50;
                    break;
                case '3':
                    $totalMission = 100;
                    break;
                default: 
                    $totalMission = 200;
                    break;
            }
            \Log::info('Package: '. json_encode($item));
            \Log::info('Total mission: '.$totalMission);
            \Log::info('Missions completed: '.$item['missions_completed_count']);
            if($item['missions_completed_count'] == $totalMission) {
                Project::where('id', $item['id'])->update(['status' => Project::COMPLETED_PROJECT]);
            }
        }
        \Log::info('ChangeStatusCompletedProjectJob:  END '.date('Y-m-d H:i:s'));
    }
}

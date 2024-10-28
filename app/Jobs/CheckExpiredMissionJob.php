<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Mission;
use Carbon\Carbon;

class CheckExpiredMissionJob implements ShouldQueue
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
        \Log::info('CheckExpiredMissionJob : START'. date('Y-m-d H:i:s'));
        // Cập nhật trạng thái nhiệm vụ khi hết hạn
        $dataMission = Mission::where('status', 2)->get()->toArray();
        $now = Carbon::now();
        foreach ($dataMission as $mission) {
            $diffMinutes = $now->diffInMinutes(Carbon::parse($mission['created_at']));
            \Log::info('Diff minutes : '.$diffMinutes);
            if ($diffMinutes >= 60) {
                Mission::where('id', $mission['id'])->update(['status' => 6]);
            }
        }
        \Log::info('CheckExpiredMissionJob : END'. date('Y-m-d H:i:s'));
    }
}

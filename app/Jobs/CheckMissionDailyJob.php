<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Services\ApiGoogleService;
use App\Models\Mission;
use App\Models\Project;

class CheckMissionDailyJob implements ShouldQueue
{
    use Queueable;


    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        \Log::info('CheckMissionDailyJob:  START '.date('Y-m-d H:i:s'));
        //Cập nhật trạng thái nhiệm đã duyệt tự động
        $project = Project::where('status', Project::WORKING_PROJECT)->get()->toArray();
        foreach ($project as $item) {
            $data = app(apiGoogleService::class)->getPlaceDetails($item['place_id']);
            $dataMission = Mission::where('status', 2)->with('comments')->get()->toArray();
            foreach ($data['reviews'] as $review) {
                \Log::info('review: '.json_encode($review));
                if(!$dataMission) return;
                foreach ($dataMission as $mission) {
                    \Log::info('mission: '.json_encode($mission));
                    $comment = $mission['comments']['comment'];
                    $reviewText = mb_convert_encoding($review['originalText']['text'], 'UTF-8');
                    \Log::info('Text original: '.$reviewText);
                    if(mb_trim($reviewText) === mb_trim($comment)) {
                        Mission::where('id', $mission['id'])->update(['status' => 7]);
                    }
                }
            }
        }
        \Log::info('CheckMissionDailyJob:  START '.date('Y-m-d H:i:s'));
    }
}

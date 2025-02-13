<?php
namespace App\Listeners;

use App\Events\ProjectImagesUploaded;
use App\Repositories\ProjectImage\ProjectImageRepositoryInterface;
use App\Repositories\ProjectImageRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleProjectImages implements ShouldQueue
{
    use InteractsWithQueue;

    protected $projectImageRepository;

    public function __construct(ProjectImageRepositoryInterface $projectImageRepository)
    {
        $this->projectImageRepository = $projectImageRepository;
    }

    public function handle(ProjectImagesUploaded $event)
    {
        $filePaths = $event->filePaths;
        $project_id = $event->project_id;
        $data = [];

        if (!empty($filePaths)) {
            $this->projectImageRepository->deleteByKey('project_id', $project_id);

            foreach ($filePaths as $path) {
                $data[] = [
                    'image_url' => $path,
                    'project_id' => $project_id,
                ];
            }

            $this->projectImageRepository->insert($data);
        }
    }
}
<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectImagesUploaded
{
    use Dispatchable, SerializesModels;

    public $filePaths;
    public $project_id;

    public function __construct(array $filePaths, $project_id)
    {
        $this->filePaths = $filePaths;
        $this->project_id = $project_id;
    }
}

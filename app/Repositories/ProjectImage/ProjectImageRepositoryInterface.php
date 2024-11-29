<?php
namespace App\Repositories\ProjectImage;

interface ProjectImageRepositoryInterface
{
    public function list($request);
    public function findImageByProject($project_id);
}

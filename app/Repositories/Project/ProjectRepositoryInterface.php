<?php
namespace App\Repositories\Project;

interface ProjectRepositoryInterface
{
    public function list($request);
    public function countData($filter = array());
    public function totalPrice($filter = array());
    public function countDataGroupMonth($filter = array());
    public function findWithComments($project_id, $request);
}

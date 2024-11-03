<?php
namespace App\Repositories\Project;

interface ProjectOrderRepositoryInterface
{
    public function list($request);
    public function countData($filter = array());
    public function wrongImages($id);
    public function find($id);
    public function countDataGroupMonth($filter = array());
}

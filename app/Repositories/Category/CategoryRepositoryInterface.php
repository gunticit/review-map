<?php
namespace App\Repositories\Category;

interface CategoryRepositoryInterface
{
    public function list($request);
    public function countData($filter = array());
    public function countDataGroupMonth($filter = array());
}

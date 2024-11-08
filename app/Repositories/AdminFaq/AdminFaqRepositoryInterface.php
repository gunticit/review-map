<?php
namespace App\Repositories\AdminFaq;

interface AdminFaqRepositoryInterface
{
    public function list($request);
    public function countData($filter = array());
    public function countDataGroupMonth($filter = array());
}

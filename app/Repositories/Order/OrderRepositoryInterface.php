<?php
namespace App\Repositories\Order;

interface OrderRepositoryInterface
{
    public function list($request);
    public function countData($filter = array());
    public function countDataGroupMonth($filter = array());
}

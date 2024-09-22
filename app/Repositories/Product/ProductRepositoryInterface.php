<?php
namespace App\Repositories\Product;

interface ProductRepositoryInterface
{
    public function list($request);
    public function countData($filter = array());
    public function countDataGroupMonth($filter = array());
}

<?php
namespace App\Repositories\Product;

interface ProductRepositoryInterface
{
    public function list($request);
    public function findBySlug($slug);
}

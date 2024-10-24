<?php
namespace App\Repositories\Support;

interface SupportRepositoryInterface
{
    public function list($request);
    public function listCreateByUser($request);
}

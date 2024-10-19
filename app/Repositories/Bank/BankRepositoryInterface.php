<?php
namespace App\Repositories\Bank;

interface BankRepositoryInterface
{
    public function list($request);
    public function countData($filter = array());
}

<?php
namespace App\Repositories\PaymentMethod;

interface PaymentMethodRepositoryInterface
{
    public function list($request);
    public function countData($filter = array());
}

<?php
namespace App\Repositories\Voucher;

interface VoucherRepositoryInterface
{
    public function list($request);
    public function countData($filter = array());
    public function countDataGroupMonth($filter = array());
    public function checkAjaxApplyVoucher($voucher_code);
}

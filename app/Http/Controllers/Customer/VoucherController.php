<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Voucher;
use App\Services\VoucherService;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    private $voucherService;
    public function __construct(
        VoucherService $voucherService
    ){
        $this->voucherService = $voucherService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function checkAjaxApplyVoucher(Request $request){
        $voucher = $this->voucherService->checkAjaxApplyVoucher($request);
        if(isset($request->project_id) && !empty($voucher)){
            Project::where('id', $request->project_id)->update(['voucher_code' => $request->voucher_code]);
            $count_voucher = isset($voucher->uses_left) ? (int)$voucher->uses_left + 1 : 1;
            Voucher::where('id', $voucher->id)->update(['uses_left' => $count_voucher]);
        }
        return $voucher;
    }
}

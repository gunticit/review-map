<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\VoucherResource;
use App\Services\VoucherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Voucher;
use App\Http\Requests\VoucherRequest;
use App\Helpers\Helper;

class VoucherController extends Controller
{
    protected $voucherService;

    public function __construct(VoucherService $voucherService)
    {
        $this->voucherService = $voucherService;
    }
    public function index(Request $request)
    {
        $vouchers = $this->voucherService->list($request);
        return view('pages.admin.voucher.list', [
            'vouchers' => $vouchers,
        ]);
    }
    public function create()
    {
        $data = array();
        return view('pages.admin.voucher.create', $data);
    }
    public function store(VoucherRequest $request)
    {
        // try {
            $this->voucherService->create($request);
            return redirect()->route('voucher.index')->with('success', 'Thêm voucher thành công!');
        // } catch (\Exception $e) {
        //     $logs = array(
        //         'module' => 'Voucher',
        //         'action' => 'Create',
        //         'msg_log' => $e->getMessage(),
        //     );
        //     Helper::trackingError($logs);

        //     return redirect()->back()->with(key: 'resp_error', value: 'An error occurred during the operation.');
        // }
    }
    public function edit($id)
    {
        $voucher = Voucher::findOrFail($id);
        return view('pages.admin.voucher.edit', compact('voucher'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(VoucherRequest $request, $id)
    {
        // try{
            $voucher = Voucher::findOrFail($id);
            $data = $this->getData($request);
            $voucher->update($data);
            return redirect()->route('voucher.index')->with('success', 'Cập nhật mã giảm giá thành công!');
        // } catch (\Exception $e) {
        //     return redirect()->back()->with('error', 'Đã có lỗi xảy ra khi cập nhật mã giảm giá.');
        // }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $voucher = Voucher::findOrFail($id);
            $voucher->delete();

            return redirect()->route('voucher.index')->with('success', 'Xóa mã giảm giá thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã có lỗi xảy ra khi xóa mã giảm giá.');
        }
    }
    public function vouchersList(Request $request)
    {
        $data = $this->voucherService->fullList($request);
        return response()->json([
            'title' => 'Load data Danh mục',
            'data' => $data
        ]);
    }
    public function getData($request){
        return array(
            'code' => $request->code ?? null,
            'name' => $request->name ?? null,
            'description' => $request->description ?? null,
            'discount_type' => $request->discount_type ?? null,
            'discount_value' => $request->discount_value ?? null,
            'start_date' => $request->start_date ?? null,
            'end_date' => $request->end_date ?? null,
            'max_uses' => $request->max_uses ?? null,
            'uses_left' => $request->uses_left ?? 0,
            'status' => $request->status ?? 'active',
            'min_order_value' => $request->min_order_value ?? 0
        );
    }
}

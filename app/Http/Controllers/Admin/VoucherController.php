<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\VoucherResource;
use App\Services\VoucherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VoucherController extends Controller
{
    protected $voucherService;
    public function __construct(VoucherService $voucherService)
    {
        $this->voucherService = $voucherService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = array();
        $vouchers = $this->voucherService->list($request);
        $vouchers = VoucherResource::collection($vouchers)->resource;
        return view('pages.admin.voucher.list', [
            'vouchers' => $vouchers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = array();
        return view('pages.admin.voucher.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'parent' => 'nullable|exists:vouchers,id',
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Giới hạn kích thước ảnh 2MB
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $this->voucherService->create($request);
            return redirect()->route('voucher.index')->with('success', 'Thêm Danh mục thành công');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('pages.admin.voucher.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('pages.admin.voucher.edit');
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
        try{
            $this->voucherService->delete($id);
            return redirect()->route('voucher.index')->with('success', 'Xoá Danh mục thành công');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function vouchersList(Request $request){
        $data = $this->voucherService->fullList($request);
        return response()->json([
            'title' => 'Load data Danh mục',
            'data' => $data
        ]);
    }
    public function destroyVoucherById(string $id)
    {
        try{
            $this->voucherService->delete($id);
            return response()->json([
                'status' => true,
                'id' => $id,
                'message' => 'Xoá Danh mục thành công'
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'id' => $id,
                'message' => $e->getMessage()
            ]);
        }
    }
}

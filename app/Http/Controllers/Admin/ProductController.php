<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    protected $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = array();
        $data['products'] = $this->productService->list($request);
        $data['categories'] = $this->productService->getCategories($request);
        return view('pages.admin.product.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $data = array();
        $data['categories'] = $this->productService->getCategories($request);
        return view('pages.admin.product.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'category_id' => 'nullable|exists:categories,id',
                'description' => 'nullable|string',
                'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Giới hạn kích thước ảnh 2MB
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $check = $this->productService->create($request);
            return redirect()->route('product.index')->with('success', 'Thêm Danh mục thành công');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('pages.admin.product.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = $this->productService->show($id);
        return view('pages.admin.product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $this->productService->update($request, $id);
            return redirect()->route('product.index')->with('success', 'Cập nhật sản phẩm thành công');
        }catch(\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $this->productService->delete($id);
            return response()->json([
                'title' => 'Xóa sản phẩm',
                'status' => true,
                'message' => 'Xóa sản phẩm thành công'
            ]);
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function productsList(Request $request){
        $data = $this->productService->fullList($request);
        return response()->json([
            'title' => 'Load data Danh mục',
            'data' => $data
        ]);
    }
    public function destroyProductById(string $id)
    {
        try{
            $this->productService->delete($id);
            return response()->json([
                'status' => true,
                'id' => $id,
                'message' => 'Xoá sản phẩm thành công'
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'id' => $id,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function productCheckCode($product_code){
        $data = $this->productService->checkCode($product_code);
        return response()->json([
            'title' => 'API Check Product By Code',
            'data' => $data,
            'status' => $data ? true : false
        ]);
    }
}

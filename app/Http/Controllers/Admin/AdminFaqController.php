<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminFaqService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminFaqController extends Controller
{
    protected $adminFaqService;
    public function __construct(AdminFaqService $adminFaqService)
    {
        $this->adminFaqService = $adminFaqService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $faqs = $this->adminFaqService->list($request);
        // $faqs = AdminFaqResource::collection($faqs)->resource;
        return view('pages.admin.admin-faq.list', [
            'faqs' => $faqs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = array();
        return view('pages.admin.admin-faq.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'content' => 'nullable|string'
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $this->adminFaqService->create($request);
            return redirect()->route('admin-faq.index')->with('success', 'Thêm faq thành công');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('pages.admin.admin-faq.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('pages.admin.admin-faq.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'content' => 'nullable|string'
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $this->adminFaqService->update($request, $id);
            return redirect()->route('admin-faq.index')->with('success', 'Cập nhật faq thành công');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $this->adminFaqService->delete($id);
            return response()->json([
                'status' => true,
                'message' => 'Bạn đã xóa thành công'
            ]);
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function faqsList(Request $request){
        $data = $this->adminFaqService->fullList($request);
        return response()->json([
            'title' => 'Load data Danh mục',
            'data' => $data
        ]);
    }
    public function destroyAdminFaqById(string $id)
    {
        try{
            $this->adminFaqService->delete($id);
            return response()->json([
                'status' => true,
                'id' => $id,
                'message' => 'Xoá faq thành công'
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

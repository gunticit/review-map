<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupportRequest;
use App\Services\SupportService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SupportController extends Controller
{
    protected $supportService;
    public function __construct(SupportService $supportService){
        $this->supportService = $supportService;
    }
    public function index(){
        return view('pages.customer.support.list');
    }
    public function edit(){
        return view('pages.customer.support.edit');
    }
    public function create(){
        return view('pages.customer.support.create');
    }
    public function store(SupportRequest $request){
        try{
            $data = $this->supportService->create($request);
            Session::flash('success', 'Khởi tạo yêu cầu hỗ trợ thành công');
            return redirect()->back()->withInput();
        }catch(Exception $e){
            Session::flash('error', 'Không thêm được yêu cầu hỗ trợ');
        }
    }
    public function update(SupportRequest $request){
        try{

            Session::flash('success', 'Khởi tạo dự án thành công');
            return redirect()->route('project.list');
        }catch(Exception $e){
            Session::flash('error', 'Không thêm được yêu cầu hỗ trợ');
            return redirect()->back()->withInput();
        }
    }
}

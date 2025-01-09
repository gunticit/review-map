<?php

namespace App\Http\Controllers;

use App\Services\GuaranteeSupportService;
use Illuminate\Http\Request;

class GuaranteeSupportController extends Controller
{
    protected $guaranteeSupportService;
    public function __construct(GuaranteeSupportService $guaranteeSupportService)
    {
        $this->guaranteeSupportService = $guaranteeSupportService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = array();
        $data['support_guarantees'] = array();
        return view('pages.customer.guarantee.list', $data);
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
}

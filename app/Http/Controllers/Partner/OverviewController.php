<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Mission;
use App\Services\WalletService;
use Illuminate\Http\Request;

class OverviewController extends Controller
{
    protected $walletService;
    public function __construct(WalletService $walletService){
        $this->walletService = $walletService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $total_mission = Mission::where('user_id', auth()->user()->id)->get()->pluck('status')->toArray();

        $balance = $this->walletService->getBalance();
        
        if(!empty($total_mission)){
            // dd($total_mission);
        }
        $data = array(
            'data_chars' => array(
                'completed' => 0,
                'money_earned' => 0
            ),
            'balance' => $balance,
            'total_mission' => 0
        );
        return view('pages.partner.overview.index', $data);
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

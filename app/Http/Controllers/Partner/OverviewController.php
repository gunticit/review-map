<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Mission;
use App\Services\TransactionHistoryService;
use App\Services\WalletService;
use Illuminate\Http\Request;

class OverviewController extends Controller
{
    protected $walletService, $transactionHistoryService;
    public function __construct(WalletService $walletService, TransactionHistoryService $transactionHistoryService){
        $this->walletService = $walletService;
        $this->transactionHistoryService = $transactionHistoryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter_year = isset($request->year) ? $request->year : date('Y');
        $total_missions = Mission::select('status', \DB::raw('count(*) as total'))
        ->where('user_id', auth()->user()->id)
        ->whereYear('created_at', $filter_year)
        ->groupBy('status')
        ->get()->toArray();
        
        $request->merge([
          'user_id' => auth()->user()->id,
          'type' => 'mined',
          'year' => $filter_year
        ]);
        $total_money_histories = $this->transactionHistoryService->totalMoneyHistoriesByField($request);
        $balance = $this->walletService->getBalance();
        
        $data_chart_complete = $data_chart_money_earned = [];
        for($i = 1; $i <= 12; $i++){
          // Nhiệm vụ đã hoàn thành
          $data_chart_complete[] = array(
            'label' => "Tháng " . $i <= 9 ? "0" . $i : $i,
            'y' => 0
          );
          // Tổng số tiền kiếm được
          $data_chart_money_earned[] = array(
            'label' => "Tháng " . $i <= 9 ? "0" . $i : $i,
            'y' => 0
          );
        }
        // 2: Đang thực hiện, 1: Đã hoàn thành, 3: Chờ hệ thống duyệt, 4: Chờ nhân viên duyệt, 5: Đã từ chối, 6: Đã hết hạn 
        $total_mission_by_status = array(
          0 => 0,
          1 => 0,
          2 => 0,
          3 => 0,
          4 => 0,
          5 => 0,
          6 => 0
        );
        
        if(!empty($total_missions)){
            foreach($total_missions as $total){
              $total_mission_by_status[$total['status']] = $total['total'];
            }
        }
        $total_mission = array_sum(array_values($total_mission_by_status));
        $data = array(
            'data_chars' => array(
                'completed' => $data_chart_complete,
                'money_earned' => $data_chart_money_earned
            ),
            'balance' => $balance,
            'total_money_histories' => $total_money_histories ?? 0,
            'total_mission_by_status' => $total_mission_by_status,
            'total_mission' => $total_mission ?? 0
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

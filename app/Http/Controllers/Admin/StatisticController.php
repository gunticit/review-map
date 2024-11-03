<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ExpenditureStatisticService;
use App\Services\MissionService;
use App\Services\ProjectService;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    protected $projectService, $missionService, $expenditureStatisticService;
    public function __construct(
        ProjectService $projectService, 
        MissionService $missionService,
        ExpenditureStatisticService $expenditureStatisticService
    )
    {
        $this->projectService = $projectService;
        $this->missionService = $missionService;
        $this->expenditureStatisticService = $expenditureStatisticService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters =  array(
            'years' => array(
                date('Y'),
                date('Y') - 1,
                date('Y') + 1
            ) 
        );
        $project_info = $this->projectService->list($request);
        $mission_price = $this->missionService->getPrice($request);
        // Tổng thu nhập ADMIN: Tổng số chi tiêu khách hàng
        $earning_by_months = $this->expenditureStatisticService->getAllExpenditure();
        $total_earning = array_sum($earning_by_months);
        // Tổng chi phí ADMIN: Tổng tiền đối tác kiếm được
        $total_expense = 0;
        // Tổng lợi nhuận
        $total_profit = $total_earning - $total_expense;
        $data_chars = array(
            'total_cost' => 0,
            'total_commission' => 0,
            'total_warranty' => 0,
        );
        return view('pages.admin.statistic.statistic', [
            'filters' => $filters,
            'earning_by_months' => $earning_by_months,
            'total_earning' =>  $total_earning, // Tổng thu nhập admin
            'total_profit' =>  $total_profit, // Lợi nhuận admin
            'total_expense' => $total_expense, // Tổng chi phí admin
            'all_price_projects' => $project_info['all_price_projects'] ?? 0,
            'data_chars' => $data_chars
        ]);
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

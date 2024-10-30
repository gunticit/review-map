<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\MissionService;
use App\Services\ProjectService;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    protected $projectService, $missionService;
    public function __construct(ProjectService $projectService, MissionService $missionService)
    {
        $this->projectService = $projectService;
        $this->missionService = $missionService;
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
        $data_chars = array(
            'total_cost' => 0,
            'total_commission' => 0,
            'total_warranty' => 0,
        );
        return view('pages.admin.statistic.statistic', [
            'filters' => $filters,
            'revenue' =>  0, // Doanh thu
            'commission' =>  0, // Hoa hồng
            'profits' =>  0, // Lợi nhuận
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

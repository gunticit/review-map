<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use App\Services\FaqService;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    protected $faqService, $dashboardService;
    public function __construct(FaqService $faqService,
      DashboardService $dashboardService
    ){
        $this->faqService = $faqService;
        $this->dashboardService = $dashboardService;
    }

    public function index(Request $request){
        $faqs = $this->faqService->list($request);
        $data = $this->dashboardService->info($request);
        $roles = \Auth::user()->getRoleNames()->first();
        return view('pages.faq',[
            'faqs' => $faqs,
            'money' => array(
                'spent' => 0
            ),
            'role_user' => $roles,
            'projects' => $data['projects'] ?? array(),
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Services\ExpenditureStatisticService;
use App\Services\FaqService;
use App\Services\ProjectService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FaqController extends Controller
{
    protected $faqService, $projectService, $expenditureStatisticService;
    public function __construct(
        FaqService $faqService,
        ProjectService $projectService,
        ExpenditureStatisticService $expenditureStatisticService
    ){
        $this->faqService = $faqService;
        $this->projectService = $projectService;
        $this->expenditureStatisticService = $expenditureStatisticService;
    }

    public function index(Request $request){
        $faqs = $this->faqService->list($request);
        $data = $this->projectService->list($request);
        $expenditure = $this->expenditureStatisticService->getAllExpenditureByUser(Auth::user()->id);
        return view('pages.faq',[
            'faqs' => $faqs,
            'money' => array(
                'spent' => $expenditure ?? 0
            ),
            'projects' => $data['projects'] ?? [],
            'total' => $data['total'] ?? 0,
            'working' => $data['working'] ?? 0,
            'stopped' => $data['stopped'] ?? 0,
        ]);
    }
}

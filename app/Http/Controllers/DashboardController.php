<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    protected $dashboardService;
    public function __construct(DashboardService $dashboardService){
        $this->middleware('auth');
        $this->dashboardService = $dashboardService;
    }
    public function changeLanguage($language){
        Session::put('language', $language);
        return redirect()->back();
    }
    public function index(Request $request){
        $data = $this->dashboardService->info($request);
        $filters =  array(
            'years' => array(
                date('Y'),
                date('Y') - 1,
                date('Y') + 1
            ) 
        );
        
        $data_completed = $data_distributed = [];

        for ($i = 1; $i <= 12; $i++) {
            $data_completed[$i] = [
                "label" => "Tháng $i",
                "y" => 0 
            ];
            $data_distributed[$i] = [
                "label" => "Tháng $i",
                "y" => 0 
            ];
        }
        $completed = $this->dashboardService->getProjectsCompleted();
        foreach ($completed as $value) {
            $month = (int)$value['month'];
            if ($month >= 1 && $month <= 12) {
                $data_completed[$month]['y'] = $value['total']; // Gán giá trị đúng cho tháng
            }
        }
        $data_completed = array_values($data_completed);

        $distributed = $this->dashboardService->getProjectsDistributed();
        foreach ($distributed as $value) {
            $month = (int)$value['month'];
            if ($month >= 1 && $month <= 12) {
                $data_distributed[$month]['y'] = $value['total']; // Gán giá trị đúng cho tháng
            }
        }
        $data_distributed = array_values($data_distributed);

        $data_chars = array(
            'completed' =>  $data_completed,
            'distributed' =>  $data_distributed,
            'spents' =>  $this->dashboardService->getMoneySpents('spents'),
        );
        return view('pages.dashboard', [
            'projects' => $data['projects'] ?? array(),
            'money' => array(
                'spent' => 0
            ),
            'filters' => $filters,
            'data_chars' => $data_chars
        ]);
    }
    public function getLongUrl(Request $request)
    {
        $shortUrl = $request->query('url');

        try {
            $ch = curl_init($shortUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false); // Không tự động theo dõi chuyển hướng
            curl_exec($ch);

            $redirectUrl = curl_getinfo($ch, CURLINFO_REDIRECT_URL);
            if ($redirectUrl) {
                preg_match('/@([-?\d+\.\d+]+),([-?\d+\.\d+]+),/', $redirectUrl, $matches);
                $coordinate = array();
                if ($matches) {
                    $coordinate['latitude'] = $matches[1];
                    $coordinate['longitude'] = $matches[2];
                }
                return response()->json(['long_url' => $redirectUrl, 'coordinate' => $coordinate]);
            }
            curl_close($ch);

            return response()->json(['error' => 'No redirection found'], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching URL: ' . $e->getMessage()], 500);
        }
    }
}

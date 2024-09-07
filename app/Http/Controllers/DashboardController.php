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
        return view('pages.dashboard', [
            'projects' => $data['projects'] ?? array(),
            'money' => array(
                'spent' => 0
            )
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

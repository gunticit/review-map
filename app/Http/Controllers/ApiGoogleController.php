<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ApiGoogleController extends Controller
{
    public function getPlaceDetails(Request $request)
    {
        if(!$request->has('place_id')) {
            return response()->json(['status' => 'error', 'message' => 'Place ID là bắt buộc'], 400);
        }
        $client = new Client();
        $url = 'https://places.googleapis.com/v1/places/'.$request->place_id;
        
        try {
            $response = $client->request('GET', $url, [
                'query' => [
                    'fields' => 'id,displayName,rating,reviews,userRatingCount,location',
                    'key' => env('GOOGLE_MAP_API_KEY')
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            return response()->json([
                'status' => 'success',
                'data' => $data,
                'message' => 'Load dữ liệu thành công'
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to fetch data'], 500);
        }
    }
}

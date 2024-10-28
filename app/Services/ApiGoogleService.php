<?php

namespace App\Services;

use GuzzleHttp\Client;

class ApiGoogleService
{
    public function getPlaceDetails($placeId)
    {
        $client = new Client();
        $url = 'https://places.googleapis.com/v1/places/'. $placeId;
        
        try {
            $response = $client->request('GET', $url, [
                'query' => [
                    'fields' => 'id,displayName,rating,reviews,userRatingCount,location',
                    'key' => env('GOOGLE_MAP_API_KEY')
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            return $data;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}

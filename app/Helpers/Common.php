<?php

    # Lấy thông tin chi tiết ngoại lệ trả về

use Illuminate\Support\Facades\Storage;

    if (!function_exists('getMessage')) {
        function getMessage($e)
        {
            try {
                $message = PHP_EOL;
                $message .= "Message: ".$e->getMessage() .PHP_EOL;
                $message .= "File: ".$e->getFile() .PHP_EOL;
                $message .= "Line: ".$e->getLine() .PHP_EOL;
                $message .= "Params: ".request()->getQueryString() .PHP_EOL;
                return $message; 
            } catch (\Throwable $e) {
                return null;
            }
        }
    }
    if (!function_exists('getSubDomain')) {
        function getSubDomain($hostName)
        {
            $domain   = env('MAIN_DOMAIN');
            $subDomain = $hostName != $domain ? str_replace("." . $domain, "", $hostName) : 'main';
            return $subDomain;
        }
    }

    if (!function_exists('getSubDomain')) {
        function getSubDomain($hostName)
        {
            $domain   = env('MAIN_DOMAIN');
            $subDomain = $hostName != $domain ? str_replace("." . $domain, "", $hostName) : 'main';
            return $subDomain;
        }
    }

    if (!function_exists('getPortal')) {
        function getPortal()
        {
            try {
                $siteName = 'main'; 
                $host = request()->getHost();
                if ($host != env('MAIN_DOMAIN')) {
                    $siteName = explode('.', $host)[0];
                }
            } catch (\Throwable $th) {
                $siteName = 'main'; 
            }
            return $siteName;
        }
    }

    if (!function_exists('generationTempUrlS3')) {
        function generateTempUrl(string|null $pathFolder, string $expiresTime, array $headers, bool $useS3 = false) {
            $parentDir = 'uploads';
            $filePath = $parentDir . '/' . getPortal() . '/' . $pathFolder;

            if ($useS3) {
                // Upload lên S3
                return Storage::disk('s3')->temporaryUrl($filePath, $expiresTime, $headers);
            } else {
                // Upload lên server cục bộ
                $fileExists = Storage::disk('local')->exists($filePath);
                if ($fileExists) {
                    $url = Storage::disk('local')->url($filePath);
                    return $url;
                }
            }
        }
    }

    if(!function_exists('moneyFormat')){
        function moneyFormat($str){
            $num = 0;
            $num = number_format($str, 0, '.', ',');
            return $num;
        }
    }

    if (!function_exists('dateNowDash')) {
        function dateNowDash()
        {
            return date('Y-m-d');
        }
    }

    if (!function_exists('dateNow')) {
        function dateNow()
        {
            return date('Y-m-d H:i:s');
        }
    }

    if (!function_exists('dayNow')) {
        function dayNow()
        {
            return date('Y/m/d');
        }
    }
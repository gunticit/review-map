<?php
    use Illuminate\Support\Facades\Storage;

    if (!function_exists('randomNumber')) {
        function randomNumber($size = 10)
        {
            $characters = '0123456789';
            $randomString = '';
            for ($i = 0; $i < $size; $i++) {
                $index = rand(0, strlen($characters) - 1);
                $randomString .= $characters[$index];
            }
            return $randomString;
        }
    }

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

    if (!function_exists('convertUserName')) {
        function convertUserName($fullname)
        {
            $name = explode(' ', $fullname);
            $name = array_slice($name, -2);
            $name = implode('_', $name);
            $name = strtolower($name) . '_' . time();
            return $name;
        }
    }

    if(!function_exists('checkStatus')){
        function checkStatus($status){
            $className = '';
            $labelStatus = '';
            switch($status) {
                case 0:
                    $className = 'text-danger';
                    $labelStatus = 'Huỷ';
                    break;
                case 1:
                    $className = 'text-success';
                    $labelStatus = 'Đang thực hiện';
                    break;
                case 2:
                    $className = 'text-success';
                    $labelStatus = 'Hoàn thành';
                    break;
                case 3:
                    $className = 'text-warning';
                    $labelStatus = 'Hoàn lại';
                    break;
                case 4:
                    $className = 'text-warning';
                    $labelStatus = 'Tạm ngưng';
                    break;
                case 5:
                    $className = 'text-warning';
                    $labelStatus = 'Chưa thanh toán';
                    break;
                default:
                    break;
            }
            return [
                'className' => $className,
                'labelStatus' => $labelStatus
            ];
        }
    }

    if(!function_exists('hashName')) {
        function hashName(string $prefix = '')
        {
            return ($prefix ? $prefix . '_' : '') . date('ymd') . "_" . randomNumber(20);
        }
    }

    if (!function_exists('getPathFolder')) {
        function getPathFolder($pathFolder)
        {
            $parentDir = 'public/uploads';
            return $parentDir.'/' . getPortal() . "/" . $pathFolder;
        }
    }

    if (!function_exists('getPathTempFolder')) {
        function getPathTempFolder($pathFolder){
            $parentDir = 'temp';
            return $parentDir.'/' . getPortal() . "/" . $pathFolder;
        }
    }

    if (!function_exists('getAssetStorageLocal')) {
        function getAssetStorageLocal($publicFolder)
        {
            $parentDir = 'storage/uploads';
            return asset($parentDir.'/'. getPortal() . "/" . $publicFolder);
        }
    }

    if(!function_exists('slugify')){
        function slugify($text, string $divider = '-')
        {
            $text = preg_replace('~[^\pL\d]+~u', $divider, $text);
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
            $text = preg_replace('~[^-\w]+~', '', $text);
            $text = trim($text, $divider);
            $text = preg_replace('~-+~', $divider, $text);
            $text = strtolower($text);
            if (empty($text)) {
                return 'n-a';
            }
            return $text;
        }
    }

    if (!function_exists('formatVND')) {
        function formatVND($number) {
            return number_format($number, 0, ',', '.') . ' ₫';
        }
    }
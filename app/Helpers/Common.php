<?php

    # Lấy thông tin chi tiết ngoại lệ trả về
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
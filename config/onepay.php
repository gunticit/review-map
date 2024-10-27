<?php
/**
 * Created by IntelliJ IDEA.
 * User: nuocgansoi
 * Date: 10/30/2017
 * Time: 3:12 PM
 */

if(isSSL()) {
    $ssl_url = 'https://';
} else {
    $ssl_url = 'http://';
}

return [
    'version' => env('ONEPAY_VERSION', 2),
    'do_url' => env('ONEPAY_DO_URL', 'https://mtf.onepay.vn/paygate/vpcpay.op'),
    'return_url' => env('ONEPAY_RETURN_URL', $ssl_url.env('CUSTOMER_DOMAIN').'/return/onepay'),
    'ipn_url' => env('ONEPAY_IPN_URL', $ssl_url.env('CUSTOMER_DOMAIN').'/ipn'),
    'merchant_id' => env('ONEPAY_MERCHANT_ID', 'TESTONEPAY31'),
    'access_code' => env('ONEPAY_ACCESS_CODE', '6BEB2566'),
    'secure_secret' => env('ONEPAY_SECURE_SECRET', '6D0870CDE5F24F34F3915FB0045120D6'),
    'command' => env('ONEPAY_COMMAND', 'pay'),
    'currency' => env('ONEPAY_CURRENCY', 'VND'),
    'locale' => env('ONEPAY_LOCALE', 'vn'),
    'title' => env('ONEPAY_TITLE', 'OnePay Gate'),
    'amount_exchange' => env('ONEPAY_AMOUNT_EXCHANGE', 100),
];

<?php
    return array(
        'store_log_request' => true,
        'per_page' => 15,
        'limit' => 15,
        'page' => 1,
        'setting_columns' => [
            'language', 
            'dark_mode'
        ],
        'status_support' => [
            1 => 'support.status_support.done', // Đã thực hiện 
            2 => 'support.status_support.unprocessed', // Chưa xử lý
            3 => 'support.status_support.in_progress', // Đang thực hiện
            4 => 'support.status_support.close', // Đóng
        ],
        'pusher_app_key' => env('PUSHER_APP_KEY'),
    );
?>
 
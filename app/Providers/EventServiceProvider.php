<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'App\Events\GenerateCommentSuccess' => [
            'App\Listeners\GenerateCommentNotify.php',
        ],
    ];
}
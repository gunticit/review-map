<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'App\Events\GenerateCommentSuccess' => [
            'App\Listeners\GenerateCommentNotify',
        ],
        'App\Events\ProjectImagesUploaded' => [
            'App\Listeners\HandleProjectImages',
        ],
    ];
}
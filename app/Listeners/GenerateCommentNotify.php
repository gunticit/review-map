<?php

namespace App\Listeners;

use App\Events\GenerateCommentSuccess;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class GenerateCommentNotify implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(GenerateCommentSuccess $event): void
    {
        //
    }
}

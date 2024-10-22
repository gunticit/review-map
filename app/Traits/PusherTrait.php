<?php

namespace App\Traits;

use Pusher\Pusher;

trait PusherTrait
{
    protected $pusher;

    public function initializePusher()
    {
        $options = [
            'cluster' => env('PUSHER_APP_CLUSTER', 'ap1'),
            'useTLS' => env('PUSHER_USE_TLS', true),
        ];

        $this->pusher = new Pusher(
            env('PUSHER_APP_KEY'), // App key
            env('PUSHER_APP_SECRET'), // App secret
            env('PUSHER_APP_ID'), // App ID
            $options
        );
    }

    public function triggerEvent($channel, $event, $data)
    {
        if (!$this->pusher) {
            $this->initializePusher();
        }

        $this->pusher->trigger($channel, $event, $data);
    }
}

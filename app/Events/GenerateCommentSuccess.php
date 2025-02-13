<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GenerateCommentSuccess
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $project_id;
    public $keyword_data;
    public $sl_comment;

    /**
     * Create a new event instance.
     */
    public function __construct($request, $project_id, $keyword_data, $sl_comment)
    {
        $this->request = $request;
        $this->project_id = $project_id;
        $this->keyword_data = $keyword_data;
        $this->sl_comment = $sl_comment;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}

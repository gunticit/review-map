<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationAdminEvent implements ShouldBroadcastNow
{
    public $data;
    public $role;
    public $userId;

    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct($data, $role, $userId = null)
    {
        $this->data = $data;
        $this->role = $role;
        $this->userId = $userId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            'send-message',
        ];
    }

    public function broadcastAs() {
        $typeEvent = $this->role === 'admin' ? 'department-' . $this->data['department_id'] : $this->role . '-'  . $this->userId;
        return "event-notification-{$typeEvent}";
    }
       
}

<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CurrentPlayerUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $gamecode;

    /**
     * Create a new event instance.
     */
    public function __construct($userId, $gamecode)
    {
        $this->userId = $userId;
        $this->gamecode = $gamecode;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('game.' . $this->gamecode),
        ];
    }

    public function broadcastAs(): string
    {
        return 'CurrentPlayerUpdated';
    }

    public function broadcastWith(): array
    {
        return [
            'userId' => $this->userId,
            'gamecode' => $this->gamecode,
        ];
    }
}

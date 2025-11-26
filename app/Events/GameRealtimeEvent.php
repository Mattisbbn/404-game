<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GameRealtimeEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public string $gamecode,
        public string $type,
        public array $data = []
    ) {
    }

    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('game.' . $this->gamecode),
        ];
    }

    public function broadcastAs(): string
    {
        return 'GameRealtimeEvent';
    }

    public function broadcastWith(): array
    {
        return [
            'type' => $this->type,
            'data' => $this->data,
        ];
    }
}


<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class GameEnded implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public string $gamecode, public array $leaderboard)
    {
    }

    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('game.' . $this->gamecode),
        ];
    }

    public function broadcastAs(): string
    {
        return 'GameEnded';
    }

    public function broadcastWith(): array
    {
        return [
            'leaderboard' => $this->leaderboard,
        ];
    }
}

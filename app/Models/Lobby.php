<?php

namespace App\Models;

use App\Events\GameStarted;
use Illuminate\Database\Eloquent\Model;

class Lobby extends Model
{
    protected $fillable = ['gamecode', 'is_active', 'is_started'];

    protected $casts = [
        'is_active' => 'boolean',
        'is_started' => 'boolean',
    ];

    public function players()
    {
        return $this->hasMany(Player::class, 'lobby_id');
    }

    public function startGame(): void
    {
        if ($this->is_started) {
            return;
        }

        $this->forceFill(['is_started' => true])->save();

        broadcast(new GameStarted($this->gamecode));
    }
}

<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Player extends Authenticatable
{
    use Notifiable;
    protected $fillable = ['username', 'lobby_id', 'score', 'status', 'color'];

    public function lobby()
    {
        return $this->belongsTo(Lobby::class, 'lobby_id');
    }
}

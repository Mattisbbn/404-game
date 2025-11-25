<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = ['username', 'lobby_id', 'score', 'status', 'color'];

    public function lobby()
    {
        return $this->belongsTo(Lobby::class, 'lobby_id');
    }
}

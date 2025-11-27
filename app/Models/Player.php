<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Player extends Authenticatable
{
    use Notifiable;
    protected $fillable = ['username', 'lobby_id', 'score', 'status', 'color', 'position', 'order', 'canRoll', 'current_question_id', 'prison_turns'];

    public function lobby()
    {
        return $this->belongsTo(Lobby::class, 'lobby_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'current_question_id');
    }
}

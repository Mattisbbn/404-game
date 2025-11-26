<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Lobby;
use Illuminate\Support\Facades\Log;
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('game.{gamecode}', function ($user, $gamecode) {
    $lobby = Lobby::where('gamecode', $gamecode)->first();
    if (!$lobby) {
        return false;
    }

    return [
        'id' => $user->id,
        'username' => $user->username,
        'status' => 'waiting',
        'color' => $user->color,
        'position' => $user->position,
        'order' => $user->order,
        'score' => $user->score,
        'canRoll' => $user->canRoll,
        'question' => $user->question,
    ];
}
);

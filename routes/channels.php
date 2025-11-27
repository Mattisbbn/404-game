<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Lobby;
use Illuminate\Support\Facades\Log;
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('game.{gamecode}', function ($user, $gamecode) {
    $lobby = Lobby::where('gamecode', $gamecode)->first();
    if (!$lobby || $user->lobby_id !== $lobby->id) {
        return false;
    }

    $user->loadMissing('question');

    return [
        'id' => $user->id,
        'username' => $user->username,
        'status' => $user->status,
        'color' => $user->color,
        'position' => $user->position,
        'order' => $user->order,
        'score' => $user->score,
        'canRoll' => (bool) $user->canRoll,
        'question' => $user->question ? $user->question->toArray() : null,
        'prison_turns' => $user->prison_turns,
    ];
});

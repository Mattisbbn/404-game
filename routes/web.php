<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\LobbyController;
use App\Models\Lobby;
use App\Models\Player;

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::post('/join-game', [LobbyController::class, 'join'])->name('join-game');

Route::get('/lobby/{gamecode}', function (string $gamecode) {

    $lobby = Lobby::where('gamecode', $gamecode)->first();
    if (!$lobby) {
        return redirect()->route('home')->with('error', 'Lobby not found');
    }

    $players = Player::where('lobby_id', $lobby->id)->get();

    return Inertia::render('Lobby', [
        'gamecode' => $gamecode,
        'players' => $players,
    ]);
})->name('lobby.show');


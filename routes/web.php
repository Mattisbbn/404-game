<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\LobbyController;
use App\Models\Lobby;
use App\Models\Player;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GameController;
Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::post('/join-game', [LobbyController::class, 'join'])->name('join-game');

Route::get('/lobby/{gamecode}', function (string $gamecode) {

    $lobby = Lobby::where('gamecode', $gamecode)->first();
    if (!$lobby) {
        return redirect()->route('home')->with('error', 'Lobby not found');
    }

    $playerId = session('player_id');
    if (!$playerId) {
        return redirect()->route('home')->with('error', 'Player not found');
    }

    if (!Auth::check()) {
        Auth::loginUsingId($playerId);
    }

    $players = Player::where('lobby_id', $lobby->id)->get();

    $status = Player::where('id', $playerId)->first()->status;


    return Inertia::render('Lobby', [
        'gamecode' => $gamecode,

        'playerId' => $playerId,
        'status' => $status,
    ]);
})->name('lobby.show');

Route::get('/game/{gamecode}', [GameController::class, 'show'])->name('game.show');
Route::post('/update-player-status/{playerId}', [LobbyController::class, 'updatePlayerStatus'])->name('update-player-status');
Route::get('/test-auth', function () {
    return [
        'user' => Auth::user(),
        'id' => Auth::id(),
        'check' => Auth::check(),
        'guard' => config('auth.defaults.guard'),
        'provider' => config('auth.guards.web.provider'),
        'model' => config('auth.providers.users.model'),
    ];
});

Route::post('/roll-dice/{gamecode}', [GameController::class, 'rollDice'])->name('roll-dice');
Route::post('/answer-question/{gamecode}', [GameController::class, 'answerQuestion'])->name('answer-question');

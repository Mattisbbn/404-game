<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lobby;
use Inertia\Inertia;
use App\Models\Player;
class GameController extends Controller
{
    public function show(string $gamecode)
    {
        $lobby = Lobby::where('gamecode', $gamecode)->first();
        if (!$lobby) {
            return redirect()->route('lobby.show', $gamecode)->with('error', 'Lobby not found');
        }
        $players = Player::where('lobby_id', $lobby->id)->get();

        $playerId = session('player_id');
        if (!$playerId) {
            return redirect()->route('lobby.show', $gamecode)->with('error', 'Player not found');
        }
        $status = Player::where('id', $playerId)->first()->status;

        return Inertia::render('Game', [
            'gamecode' => $gamecode,
        ]);
    }
}

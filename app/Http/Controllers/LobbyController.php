<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lobby;
use App\Models\Player;


class LobbyController extends Controller
{
    public function join(Request $request)
    {
        $colors = ['purple', 'blue', 'green', 'yellow', 'orange', 'red', 'pink', 'brown'];


        $gamecode = $request->get('gamecode');
        $username = $request->get('username');

        $lobby = Lobby::firstOrCreate(['gamecode' => $gamecode]);

        $player = Player::create([
            'username' => $username,
            'lobby_id' => $lobby->id,
            'status' => 'waiting',
            'color' => $colors[array_rand($colors)],
            'score' => 0,
        ]);


        $playerId = $player->id;

        session(['player_id' => $playerId]);



        return redirect()->route('lobby.show', ['gamecode' => $lobby->gamecode]);
    }
}

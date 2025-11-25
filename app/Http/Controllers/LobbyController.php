<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lobby;
use App\Models\Player;


class LobbyController extends Controller
{
    public function join(Request $request)
    {
        $gamecode = $request->get('gamecode');
        $username = $request->get('username');

        $lobby = Lobby::firstOrCreate(['gamecode' => $gamecode]);

        $player = Player::create([
            'username' => $username,
            'lobby_id' => $lobby->id,
        ]);

        return redirect()->route('lobby.show', ['gamecode' => $lobby->gamecode]);
    }
}

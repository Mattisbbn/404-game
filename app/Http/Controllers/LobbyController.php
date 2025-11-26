<?php

namespace App\Http\Controllers;

use App\Events\GameRealtimeEvent;
use Illuminate\Http\Request;
use App\Models\Lobby;
use App\Models\Player;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;


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
            'position' => 0,
            'order' => 0,
        ]);


        $playerId = $player->id;

        session(['player_id' => $playerId]);
        Auth::login($player);

        return redirect()->route('lobby.show', ['gamecode' => $lobby->gamecode]);
    }

    public function updatePlayerStatus(Request $request, $playerId)
    {
        $player = Player::find($playerId);
        $player->status = $request->get('status');
        $player->save();

        broadcast(new \App\Events\PlayerStatusUpdated($player->id, $player->status, $player->lobby->gamecode));

        $players = Player::where('lobby_id', $player->lobby_id)->get();

        $playersReady = $players->where('status', 'ready')->count();
        if ($playersReady === $players->count() && $players->count() > 0) {
            $shuffledPlayers = $players->shuffle()->values();

            $shuffledPlayers->each(function (Player $lobbyPlayer, int $index) {
                $lobbyPlayer->order = $index + 1;
                $lobbyPlayer->is_current = false;
                $lobbyPlayer->save();
            });

            $firstPlayer = $shuffledPlayers->first();
            if ($firstPlayer) {
                $firstPlayer->is_current = true;
                $firstPlayer->save();

                broadcast(new GameRealtimeEvent(
                    gamecode: $player->lobby->gamecode,
                    type: 'currentPlayer',
                    data: [
                        'player' => Arr::only(
                            $firstPlayer->toArray(),
                            ['id', 'username', 'color', 'order', 'position', 'score']
                        ),
                    ],
                ));
            }

            $player->lobby->startGame();
        }

        return response()->json(['status' => $player->status]);
    }


}

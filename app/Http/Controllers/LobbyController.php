<?php

namespace App\Http\Controllers;

use App\Events\GameRealtimeEvent;
use Illuminate\Http\Request;
use App\Models\Lobby;
use App\Models\Player;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Exception;

class LobbyController extends Controller
{
    public function join(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'gamecode' => ['required', 'string', 'size:6'],
        ]);

        $colors = ['purple', 'blue', 'green', 'yellow', 'orange', 'red', 'pink', 'brown'];

        try {
            $gamecode = $request->string('gamecode')->value();
            $username = $request->string('username')->value();

            $lobby = Lobby::firstOrCreate(['gamecode' => $gamecode]);

            if ($lobby->is_started) {
                throw ValidationException::withMessages([
                    'gamecode' => 'Game already started',
                ]);
            }

            $player = Player::where('lobby_id', $lobby->id)
                ->where('username', $username)
                ->first();

            if ($player) {
                $player->status = 'waiting';
                $player->save();
            } else {
                $player = Player::create([
                    'username' => $username,
                    'lobby_id' => $lobby->id,
                    'status' => 'waiting',
                    'color' => $colors[array_rand($colors)],
                    'score' => 0,
                    'position' => 0,
                    'order' => 0,
                ]);
            }

            session(['player_id' => $player->id]);
            Auth::login($player);

            return redirect()->route('lobby.show', ['gamecode' => $lobby->gamecode]);
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            throw ValidationException::withMessages([
                'gamecode' => $e->getMessage(),
            ]);
        }
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

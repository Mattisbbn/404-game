<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lobby;
use Inertia\Inertia;
use App\Models\Player;
use App\Events\GameRealtimeEvent;
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

    public function updateCurrentPlayer(Request $request, $gamecode)
    {
        $playerId = $request->get('playerId');
        $player = Player::find($playerId);
        $player->is_current = !$player->is_current;
        $player->save();
        broadcast(new \App\Events\CurrentPlayerUpdated($playerId, $gamecode));
        return response()->json(['success' => true, 'is_current' => $player->is_current]);
    }

    public function rollDice(Request $request, $gamecode)
    {
        $result = $request->get('result');
        $playerId = session('player_id');
        $player = Player::find($playerId);
        if (!$player) {
            return response()->json(['success' => false, 'message' => 'Player not found']);
        }
        if(!$player->is_current) {
            return response()->json(['success' => false, 'message' => 'Not your turn']);
        }
        $player->position += $result;
        $player->save();
        broadcast(event: new GameRealtimeEvent(
            gamecode: $gamecode,
            type: 'rollDiceResult',
            data: [
                'result' => $result,
                'position' => $player->position,
            ],
        ));
        return response()->json(['success' => true, 'position' => $player->position]);
    }
}

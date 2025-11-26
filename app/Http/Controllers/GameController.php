<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lobby;
use Inertia\Inertia;
use App\Models\Player;
use App\Events\GameRealtimeEvent;
use App\Models\Gameboard;
use App\Models\Question;
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

        $currentPlayer = Player::where('lobby_id', $lobby->id)
            ->where('is_current', true)
            ->first();

        return Inertia::render('Game', [
            'gamecode' => $gamecode,
            'currentPlayerId' => $currentPlayer?->id,
        ]);
    }

    public function updateCurrentPlayer(Request $request, $gamecode)
    {
        $playerId = $request->get('playerId');
        $player = Player::find($playerId);
        $player->is_current = !$player->is_current;
        $player->save();
        broadcast(new \App\Events\CurrentPlayerUpdated(
            userId: $playerId,
            gamecode: $gamecode,
            isCurrent: $player->is_current,
        ));
        return response()->json(['success' => true, 'is_current' => $player->is_current]);
    }

    public function rollDice(Request $request, $gamecode)
    {
        $result = $request->get(key: 'result');
        $playerId = $request->get('playerId');
        $lobby = Lobby::where('gamecode', $gamecode)->first();
        if (!$lobby) {
            return response()->json(['success' => false, 'message' => 'Lobby not found']);
        }

        $player = Player::find($playerId);

        if (!$player) {
            return response()->json(['success' => false, 'message' => 'Player not found']);
        }
        if(!$player->is_current) {
            return response()->json(['success' => false, 'message' => 'Not your turn']);
        }

        if(!$player->canRoll) {
            return response()->json(['success' => false, 'message' => 'You have already rolled the dice']);
        }


        $maxPosition = Gameboard::max('position');
        $boardSize   = $maxPosition + 1;

        $totalSteps = $player->position + $result;
        $player->position = $totalSteps % $boardSize;

        $gameboard = Gameboard::where('position', $player->position)->first();
        $player->canRoll = false;
        $player->save();
        broadcast(event: new GameRealtimeEvent(
            gamecode: $gamecode,
            type: 'rollDiceResult',
            data: [
                'player_id' => $player->id,
                'result' => $result,
                'category' => $gameboard->category,
                'position' => $player->position,
            ],
        ));


        $question = Question::where('category', $gameboard->category)->inRandomOrder()->first();
        if (!$question) {
            return response()->json(['success' => false, 'message' => 'Question not found']);
        }

        $player->current_question_id = $question->id;
        $player->save();

        broadcast(event: new GameRealtimeEvent(
            gamecode: $gamecode,
            type: 'question',
            data: [
                    'player_id' => $player->id,
                    'question' => $player->question,
            ],
        ));

        return response()->json(['success' => true, 'question' => $question]);
    }

    public function answerQuestion(Request $request, $gamecode)
    {
        $user_answer = $request->get('answer');
        $questionId = $request->get('questionId');
        $playerId = $request->get('playerId');

        $lobby = Lobby::where('gamecode', $gamecode)->first();

        if (!$lobby) {
            return response()->json(['success' => false, 'message' => 'Lobby not found']);
        }

        $player = Player::find($playerId);

        if (!$player) {
            return response()->json(['success' => false, 'message' => 'Player not found']);
        }

        $question = Question::find($questionId);
        if (!$question) {
            return response()->json(['success' => false, 'message' => 'Question not found']);
        }
        $selectedAnswerEntry = collect($question->answers)->firstWhere('letter', $user_answer);
        $correct_answer = (bool) ($selectedAnswerEntry['isCorrect'] ?? false);

        if ($correct_answer) {
            $player->score += (int) $question->points;
        }
        $player->current_question_id = null;
        $player->canRoll = true;
        $player->is_current = false;
        $player->save();
        broadcast(event: new GameRealtimeEvent(
            gamecode: $gamecode,
            type: 'questionAnsweredResult',
            data: [
                'player_id' => $player->id,
                'question' => $player->question,
                'correct_answer' => $correct_answer,
            ],
        ));




        return response()->json([
            'success' => true,
            'message' => 'Question answered correctly',
            'correct_answer' => $correct_answer ?? '',
            'question' => $player->question,
            'answer' => $user_answer,
            'player' => $player,
            'lobby' => $lobby,
        ]);
    }
}

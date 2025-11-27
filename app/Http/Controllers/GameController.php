<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lobby;
use Inertia\Inertia;
use App\Models\Player;
use App\Events\GameRealtimeEvent;
use App\Models\Gameboard;
use App\Models\Question;
use Exception;
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
            'playerId' => $playerId,
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
        $question = null;

        try {
            $result = $request->get(key: 'result');
            $playerId = $request->get('playerId');
            $lobby = Lobby::where('gamecode', $gamecode)->first();

            if (!$lobby) {
                throw new Exception('Lobby not found');
            }

            $player = Player::find($playerId);

            if (!$player) {
                throw new Exception('Player not found');
            }

            if (!$player->is_current) {
                throw new Exception('Not your turn');
            }

            if (!$player->canRoll) {
                throw new Exception('You cannot roll the dice right now');
            }

            $turnOutcome = $this->resolveBoardState($player, (int) $result);
            [
                'category' => $category,
                'currentPosition' => $currentPosition,
                'requiresQuestion' => $requiresQuestion,
                'scoreUpdated' => $scoreUpdated,
                'bonusAwarded' => $bonusAwarded,
                'malusApplied' => $malusApplied,
                'skipNextTurn' => $skipNextTurn,
            ] = $turnOutcome;

            $player->save();

            $nextCanRollState = !$requiresQuestion;
            Player::where('lobby_id', $lobby->id)->update(['canRoll' => $nextCanRollState]);

            if ($requiresQuestion) {
                $question = $this->askQuestion($player, $category, $gamecode);
                if (!$question) {
                    throw new Exception('Question not found');
                }
            }

            $nextPlayer = $this->getNextPlayer($player, $lobby);
            $rollDicePayload = [
                'player_id' => $player->id,
                'result' => $result,
                'category' => $category,
                'position' => $currentPosition,
                'score' => $player->score,
                'bonus' => $bonusAwarded,
                'malus' => $malusApplied,
                'requiresQuestion' => $requiresQuestion,
                'canRoll' => $nextCanRollState,
                'prison_turns' => $player->prison_turns,
                'skipNextTurn' => $skipNextTurn,
            ];

            broadcast(event: new GameRealtimeEvent(
                gamecode: $gamecode,
                type: 'rollDiceResult',
                data: $rollDicePayload,
            ));

            $this->rotateCurrentPlayer($player, $nextPlayer, $gamecode);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }

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
        $isCorrect = (bool) ($selectedAnswerEntry['isCorrect'] ?? false);

        if ($isCorrect) {
            $player->score += (int) $question->points;
        }
        $player->current_question_id = null;
        $player->save();

        // Réactiver canRoll pour TOUS les joueurs après avoir répondu
        Player::where('lobby_id', $lobby->id)->update(['canRoll' => true]);
        broadcast(event: new GameRealtimeEvent(
            gamecode: $gamecode,
            type: 'questionAnsweredResult',
            data: [
                'player_id' => $player->id,
                'question' => $player->question,
                'isCorrect' => $isCorrect,
                'score' => $player->score,
                'canRoll' => true, // Indiquer que tout le monde peut relancer
            ],
        ));





        return response()->json([
            'success' => true,
            'isCorrect' => $isCorrect,
            'question' => $player->question,
            'answer' => $user_answer,
            'playerId' => $playerId,
        ]);
    }

    private function resolveBoardState(Player $player, int $diceResult): array
    {
        $category = null;
        $requiresQuestion = true;
        $scoreUpdated = false;
        $bonusAwarded = false;
        $malusApplied = false;
        $skipNextTurn = false;

        if ($player->prison_turns > 0) {
            $player->prison_turns -= 1;
            $category = 'prison';
            $requiresQuestion = false;
        } else {
            if ($diceResult === 6) {
                $category = 'cyber_risk';
            } else {
                $maxPosition = Gameboard::max('position');
                $boardSize = $maxPosition + 1;
                $player->position = ($player->position + $diceResult) % $boardSize;

                $gameboard = Gameboard::where('position', $player->position)->first();
                $category = $gameboard?->category ?? 'password';
            }

            switch ($category) {
                case 'bonus':
                    $player->score += 2;
                    $scoreUpdated = true;
                    $requiresQuestion = false;
                    $bonusAwarded = true;
                    break;
                case 'malus':
                    $player->score = max(0, $player->score - 2);
                    $scoreUpdated = true;
                    $requiresQuestion = false;
                    $malusApplied = true;
                    break;
                case 'prison':
                    $player->prison_turns = 1;
                    $requiresQuestion = false;
                    $skipNextTurn = true;
                    break;
                case '':
                case null:
                    $requiresQuestion = false;
                    break;
            }
        }

        if (!$requiresQuestion) {
            $player->current_question_id = null;
        }

        if ($player->prison_turns > 0) {
            $skipNextTurn = true;
        }


        return [
            'category' => $category,
            'currentPosition' => $player->position,
            'requiresQuestion' => $requiresQuestion,
            'scoreUpdated' => $scoreUpdated,
            'bonusAwarded' => $bonusAwarded,
            'malusApplied' => $malusApplied,
            'skipNextTurn' => $skipNextTurn,
        ];
    }

    private function askQuestion(Player $player, ?string $category, string $gamecode): ?Question
    {
        $question = Question::where('category', $category)->inRandomOrder()->first();

        if (!$question) {
            return null;
        }

        $player->current_question_id = $question->id;
        $player->save();

        broadcast(event: new GameRealtimeEvent(
            gamecode: $gamecode,
            type: 'question',
            data: [
                'player_id' => $player->id,
                'question' => $question,
            ],
        ));

        return $question;
    }

    private function updateCurrentPlayerState(Player $player, string $gamecode, bool $isCurrent): void
    {
        $player->is_current = $isCurrent;
        $player->save();

        broadcast(new \App\Events\CurrentPlayerUpdated(
            userId: $player->id,
            gamecode: $gamecode,
            isCurrent: $isCurrent,
        ));
    }

    private function getNextPlayer(Player $player, Lobby $lobby): Player
    {
        $allPlayers = Player::where('lobby_id', $lobby->id)
            ->where('order', '>', 0)
            ->orderBy('order')
            ->get();

        if ($allPlayers->isEmpty()) {
            return $player;
        }

        if ($allPlayers->count() === 1) {
            return $player;
        }

        return $allPlayers->firstWhere('order', '>', $player->order)
            ?? $allPlayers->first()
            ?? $player;
    }

    private function rotateCurrentPlayer(Player $currentPlayer, Player $nextPlayer, string $gamecode): void
    {
        if ($currentPlayer->id === $nextPlayer->id) {
            $this->updateCurrentPlayerState($currentPlayer, $gamecode, true);
            return;
        }

        $this->updateCurrentPlayerState($currentPlayer, $gamecode, false);
        $this->updateCurrentPlayerState($nextPlayer, $gamecode, true);
    }
}

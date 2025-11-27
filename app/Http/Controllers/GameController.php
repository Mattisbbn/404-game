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

        $hasCurrentPlayer = Player::where('lobby_id', $lobby->id)
            ->where('is_current', true)
            ->exists();

        // Vérifier que c'est le tour du joueur
        if(!$player->is_current) {
            // Si personne n'est désigné comme joueur courant (ex : partie solo), on le définit
            if(!$hasCurrentPlayer) {
                $player->is_current = true;
                $player->save();
                broadcast(new \App\Events\CurrentPlayerUpdated(
                    userId: $player->id,
                    gamecode: $gamecode,
                    isCurrent: true,
                ));
            } else {
                return response()->json(['success' => false, 'message' => 'Not your turn']);
            }
        }

        // Vérifier si le joueur a déjà lancé
        if(!$player->canRoll) {
            return response()->json(['success' => false, 'message' => 'You have already rolled the dice']);
        }


        $category = null;
        $currentPosition = $player->position;

        if ((int) $result === 6) {
            // Si le joueur fait 6, il reste sur place et obtient une question Cyber Risk
            $category = 'cyber_risk';
            $gameboard = null;
        } else {
            $maxPosition = Gameboard::max('position');
            $boardSize   = $maxPosition + 1;

            $totalSteps = $player->position + $result;
            $player->position = $totalSteps % $boardSize;
            $currentPosition = $player->position;

            $gameboard = Gameboard::where('position', $player->position)->first();
            $category = $gameboard?->category ?? 'password';
        }

        // Désactiver canRoll pour TOUS les joueurs
        Player::where('lobby_id', $lobby->id)->update(['canRoll' => false]);

        broadcast(event: new GameRealtimeEvent(
            gamecode: $gamecode,
            type: 'rollDiceResult',
            data: [
                'player_id' => $player->id,
                'result' => $result,
                'category' => $category,
                'position' => $currentPosition,
                'canRoll' => false, // Indiquer que plus personne ne peut lancer
            ],
        ));


        $question = Question::where('category', $category)->inRandomOrder()->first();
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

        // Désigner le prochain joueur
        $allPlayers = Player::where('lobby_id', $lobby->id)
            ->where('order', '>', 0)
            ->orderBy('order')
            ->get();

        if ($allPlayers->count() > 1) {
            // Retirer is_current du joueur actuel
            $player->is_current = false;
            $player->save();
            broadcast(new \App\Events\CurrentPlayerUpdated(
                userId: $player->id,
                gamecode: $gamecode,
                isCurrent: false,
            ));

            // Trouver le prochain joueur selon l'ordre
            $currentOrder = $player->order;
            $nextPlayer = $allPlayers->firstWhere('order', '>', $currentOrder);

            // Si aucun joueur avec un ordre supérieur, prendre le premier (boucle)
            if (!$nextPlayer) {
                $nextPlayer = $allPlayers->first();
            }

            // Désigner le prochain joueur
            $nextPlayer->is_current = true;
            $nextPlayer->save();
            broadcast(new \App\Events\CurrentPlayerUpdated(
                userId: $nextPlayer->id,
                gamecode: $gamecode,
                isCurrent: true,
            ));
        } else {
            // Si un seul joueur, le garder comme joueur courant
            $player->is_current = true;
            $player->save();
            broadcast(new \App\Events\CurrentPlayerUpdated(
                userId: $player->id,
                gamecode: $gamecode,
                isCurrent: true,
            ));
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
}

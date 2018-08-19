<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Deck;

class GameController extends Controller
{
    public function show($id)
    {
        $game = Game::find($id);

        if (!$game) {
            return view('game.no-show');
        }

        return view('game.show', [
            'game' => $game,
        ]);
    }

    public function create()
    {
        $deck = Deck::create();
        $game = Game::create(['deck_id' => $deck->id]);
        return redirect("/game/{$game->id}");
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Game;

class GameController extends Controller
{
    public function show($id)
    {
        $game = Game::find($id);
        return view('game.show', [
            'game' => $game,
        ]);
    }

    public function create()
    {
        $game = Game::create();
        return redirect("/game/{$game->id}");
    }
}

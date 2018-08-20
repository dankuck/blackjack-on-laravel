<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Deck;
use App\Libs\Dealer;
use Illuminate\Support\Facades\App;

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
        $dealer = new Dealer($game);
        $dealer->deal();
        return redirect("/game/{$game->id}");
    }

    public function hit($id)
    {
        $game = Game::findOrFail($id);
        $dealer = App::makeWith(Dealer::class, ['game' => $game]);
        $dealer->hitPlayer();
        $dealer->hitDealerOrStand();
        return redirect("/game/{$game->id}");
    }

    public function stand($id)
    {
        $game = Game::findOrFail($id);
        $dealer = App::makeWith(Dealer::class, ['game' => $game]);
        $dealer->hitDealerUntilStand();
        $game->decideWinner();
        return redirect("/game/{$game->id}");
    }

    public function deal($id)
    {
        $game = Game::findOrFail($id);
        $dealer = App::makeWith(Dealer::class, ['game' => $game]);
        $dealer->deal();
        return redirect("/game/{$game->id}");
    }
}

<?php

namespace Tests;

use App\Models\Game;

class GameControllerTest extends TestCase
{

    public function testShowFresh()
    {
        $game = factory(Game::class)->create();

        $this->get("/game/{$game->id}")
            ->see("there's a game here");
    }

    public function testShowNoSuchGame()
    {
        $this->get("/game/BAD_ID")
            ->see("there's no game here");
    }
}

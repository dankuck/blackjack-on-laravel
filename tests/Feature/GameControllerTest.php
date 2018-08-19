<?php

namespace Tests\Feature;

use App\Models\Game;

class GameControllerTest extends \Tests\TestCase
{

    public function testShowFresh()
    {
        $game = factory(Game::class)->create();

        $this->get("/game/{$game->id}")
            ->assertStatus(200)
            ->assertViewHas('game');
    }

    public function testShowNoSuchGame()
    {
        $this->get("/game/BAD_ID")
            ->assertViewHas('game', null);
    }

    public function testCreate()
    {
        $this->post('/game')
            ->assertRedirect();
    }
}

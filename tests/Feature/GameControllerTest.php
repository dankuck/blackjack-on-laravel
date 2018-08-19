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
            ->assertViewMissing('game');
    }

    public function testCreate()
    {
        $this->post('/game')
            ->assertRedirect();

        $games = Game::all();
        $this->assertCount(1, $games);
        
        $game = $games[0];
        $this->assertCount(2, $game->player_hand);
        $this->assertCount(2, $game->dealer_hand);
        $this->assertCount(48, $game->deck->cards);
    }
}

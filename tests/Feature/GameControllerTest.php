<?php

namespace Tests\Feature;

use App\Libs\Dealer;
use App\Models\Game;
use Illuminate\Support\Facades\App;
use Mockery;

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

    public function testHit()
    {
        $game = factory(Game::class)->create();
        $this->assertCount(0, $game->dealer_hand);
        $this->assertCount(0, $game->player_hand);
        $this->assertCount(52, $game->deck->cards);
        $this->post("/game/{$game->id}/hit")
            ->assertRedirect();
            
        $game = $game->fresh();
        $this->assertCount(1, $game->dealer_hand);
        $this->assertCount(1, $game->player_hand);
        $this->assertCount(50, $game->deck->cards);
    }
}

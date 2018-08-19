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
        $dealer = Mockery::mock(Dealer::class);
        $dealer->shouldReceive('hitPlayer')
            ->once();
        $dealer->shouldReceive('hitDealerOrStand')
            ->once();
        App::bind(Dealer::class, function () use ($dealer) { return $dealer; });

        $game = factory(Game::class)->create();
        $this->post("/game/{$game->id}/hit")
            ->assertRedirect();
    }
}

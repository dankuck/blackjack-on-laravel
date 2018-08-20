<?php

namespace Tests\Feature;

use App\Libs\Dealer;
use App\Models\Game;
use App\Models\Deck;
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

    public function testStand()
    {
        $game = factory(Game::class)->create();
        $this->assertCount(0, $game->dealer_hand);
        $this->assertCount(0, $game->player_hand);
        $this->assertCount(52, $game->deck->cards);
        $this->post("/game/{$game->id}/stand")
            ->assertRedirect();
            
        $game = $game->fresh();
        $this->assertTrue($game->dealer_hand_values[0] > 16);
        $this->assertCount(0, $game->player_hand);
        $this->assertEquals(52, count($game->deck->cards) + count($game->dealer_hand));
    }

    public function testWinCondition()
    {
        $game = factory(Game::class)->create();
        $this->assertNull($game->winner);

        $game->player_hand = ['AH', 'QH']; // 21
        $game->dealer_hand = ['QH', 'QS']; // 20
        $game->save();
        $this->post("/game/{$game->id}/stand")
            ->assertRedirect();

        $game = $game->fresh();
        $this->assertEquals(Game::PLAYER, $game->winner);
        $this->assertEquals(1, $game->player_wins);
    }

    public function testDeal()
    {
        $deck = factory(Deck::class)->create();
        $deck->take(10);
        $deck->save();
        $game = factory(Game::class)->create([
            'winner'      => Game::PLAYER,
            'dealer_hand' => ['AS', 'AS', 'AS'],
            'player_hand' => ['AS', 'AS', 'AS', 'AS'],
            'deck_id'     => $deck->id,
        ]);
        $this->assertCount(3, $game->dealer_hand);
        $this->assertCount(4, $game->player_hand);
        $this->assertCount(42, $game->deck->cards);
        $this->assertEquals(Game::PLAYER, $game->winner);

        $this->post("game/{$game->id}/deal")
            ->assertRedirect();

        $game = $game->fresh();
        $this->assertCount(2, $game->dealer_hand);
        $this->assertCount(2, $game->player_hand);
        $this->assertCount(38, $game->deck->cards);
        $this->assertNull($game->winner);
    }
}

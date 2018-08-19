<?php

namespace Tests\Unit;

use App\Models\Game;
use App\Models\Deck;

class GameTest extends \Tests\TestCase
{
    public function testExists()
    {
        new Game();
    }

    public function testDeck()
    {
        $deck = Deck::create();
        $game = Game::create(['deck_id' => $deck->id]);
        $this->assertEquals($deck->id, $game->deck->id);
    }

    public function testPlayerHand()
    {
        $game = factory(Game::class)->create();
        $this->assertCount(0, $game->player_hand);

        $game->player_hand = Deck::create()->cards;
        $game->save();
        $this->assertCount(52, $game->player_hand);
    }

    public function testDealerHand()
    {
        $game = factory(Game::class)->create();
        $this->assertCount(0, $game->dealer_hand);

        $game->dealer_hand = Deck::create()->cards;
        $game->save();
        $this->assertCount(52, $game->dealer_hand);
    }
}

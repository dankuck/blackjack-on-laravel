<?php

namespace Tests\Unit;

use App\Models\Game;
use App\Models\Deck;

class GameTest extends \Tests\TestCase
{
    public function testExists()
    {
        $game = Game::create();
        $this->assertNotNull($game);
    }

    public function testDeck()
    {
        $game = Game::create();
        $deck = factory(Deck::class)->create(['game_id' => $game->id]);
        $this->assertEquals($deck->id, $game->deck->id);
    }
}

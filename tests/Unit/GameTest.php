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
        $deck = factory(Deck::class)->create();
        $game = factory(Game::class)->create(['deck_id' => $deck->id]);
        $this->assertEquals($deck->id, $game->deck->id);
    }
}

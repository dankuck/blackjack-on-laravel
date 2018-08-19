<?php

namespace Tests\Unit;

use App\Models\Deck;

class DeckTest extends \Tests\TestCase
{
    public function testExists()
    {
        $deck = Deck::create(['game_id' => 0]);
        $this->assertNotNull($deck);
    }

    public function testCards()
    {
        $deck = Deck::create(['game_id' => 0]);
        $this->assertCount(52, $deck->cards);
    }

    public function testCardsAreShuffled()
    {
        $deck1 = Deck::create(['game_id' => 0]);
        $deck2 = Deck::create(['game_id' => 0]);

        $this->assertNotEquals($deck1->cards, $deck2->cards);
    }

}

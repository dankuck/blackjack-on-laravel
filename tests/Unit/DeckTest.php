<?php

namespace Tests\Unit;

use App\Models\Deck;

class DeckTest extends \Tests\TestCase
{
    public function testExists()
    {
        $deck = Deck::create();
        $this->assertNotNull($deck);
    }

    public function testCards()
    {
        $deck = Deck::create();
        $this->assertCount(52, $deck->cards);
    }

    public function testCardsAreShuffled()
    {
        $deck1 = Deck::create();
        $deck2 = Deck::create();

        $this->assertNotEquals($deck1->cards, $deck2->cards);
    }

    public function testRemainingCardCount()
    {
        $deck = Deck::create();
        $this->assertEquals(52, $deck->card_count);

        $deck->cards = array_slice($deck->cards, 0, 13);
        $this->assertEquals(13, $deck->card_count);
    }
}

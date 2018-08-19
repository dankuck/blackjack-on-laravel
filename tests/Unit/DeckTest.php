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

    public function testTakeN()
    {
        $deck = Deck::create();
        $n = mt_rand(1, 52);
        $taken = $deck->take($n);
        $this->assertCount($n, $taken);
        $this->assertCount(52 - $n, $deck->cards);
    }

    public function testTakeDefault()
    {
        $deck = Deck::create();
        $n = mt_rand(1, 52);
        $taken = $deck->take();
        $this->assertCount(1, $taken);
        $this->assertCount(51, $deck->cards);
    }

    public function testDone()
    {
        $deck = Deck::create();
        $this->assertFalse($deck->done());
        $deck->cards = [];
        $this->assertTrue($deck->done());
    }
}

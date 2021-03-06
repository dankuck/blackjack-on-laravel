<?php

namespace Tests\Unit;

use App\Events\LowDeck;
use App\Models\Deck;
use App\Models\Game;
use Illuminate\Support\Facades\Event;

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

    public function testIsDone()
    {
        $deck = Deck::create();
        $this->assertFalse($deck->is_done);
        $deck->cards = [];
        $this->assertTrue($deck->is_done);

        $not_enough = floor(Deck::SIZE * Deck::LOW_THRESHOLD);
        $just_enough = $not_enough + 1;
        $cards = Deck::create()->cards;

        $deck = Deck::create(['cards' => array_slice($cards, 0, $not_enough)]);
        $this->assertTrue($deck->is_done);

        $deck = Deck::create(['cards' => array_slice($cards, 0, $just_enough)]);
        $this->assertFalse($deck->is_done);
    }

    public function testFiresLowDeckEvent()
    {
        $deck = factory(Game::class)->create()->deck;

        Event::listen(LowDeck::class, function ($event) use (&$caught_event) {
            $caught_event = $event;
        });

        $deck->cards = [];
        $deck->save();
        $this->assertEquals($deck, $caught_event->deck);
    }

    public function testGame()
    {
        $game = factory(Game::class)->create();
        $this->assertEquals($game->id, $game->deck->game->id);
    }
}

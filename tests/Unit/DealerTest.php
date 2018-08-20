<?php

namespace Tests\Unit;

use App\Libs\Dealer;
use App\Models\Game;
use App\Models\Deck;

class DealerTest extends \Tests\TestCase
{
    public function testExists()
    {
        $game = factory(Game::class)->create();
        new Dealer($game);
    }

    public function testHitPlayer()
    {
        $game = factory(Game::class)->create();
        $dealer = new Dealer($game);

        $this->assertCount(0, $game->player_hand);
        $this->assertCount(52, $game->deck->cards);
        $dealer->hitPlayer();
        $this->assertCount(1, $game->player_hand);
        $this->assertCount(51, $game->deck->cards);
    }

    /**
     * The dealer should stand when the minimum value of the hand is greater 
     * than 16.
     */
    public function testDealerShouldStand()
    {
        $game = factory(Game::class)->create();
        $dealer = new Dealer($game);

        $this->assertFalse($dealer->dealerShouldStand());

        // values [2]
        $game->dealer_hand = ['2H'];
        $this->assertFalse($dealer->dealerShouldStand());

        // values [16]
        $game->dealer_hand = ['4H', '4D', '4S', '4C'];
        $this->assertFalse($dealer->dealerShouldStand());

        // values [17]
        $game->dealer_hand = ['4H', '4D', '4S', '5C'];
        $this->assertTrue($dealer->dealerShouldStand());

        // values [1, 11]
        $game->dealer_hand = ['AH'];
        $this->assertFalse($dealer->dealerShouldStand());

        // values [2, 12, 12, 22]
        $game->dealer_hand = ['AH', 'AD'];
        $this->assertFalse($dealer->dealerShouldStand());

        // values [17, 27]
        $game->dealer_hand = ['4H', '4D', '4S', '4C', 'AD'];
        $this->assertTrue($dealer->dealerShouldStand());
    }

    public function testHitDealerOrStand_Hit()
    {
        $game = factory(Game::class)->create();
        $dealer = new Dealer($game);

        $this->assertCount(0, $game->dealer_hand);
        $this->assertCount(52, $game->deck->cards);
        $dealer->hitDealerOrStand();
        $this->assertCount(1, $game->dealer_hand);
        $this->assertCount(51, $game->deck->cards);
    }

    /**
     * 2 cards worth 10 equal 20, which is greater than 16, the cut-off
     */
    public function testHitDealerOrStand_Stand()
    {
        $game = factory(Game::class)->create();
        $game->dealer_hand = ['4H', '4D', '4S', '5C'];
        $dealer = new Dealer($game);

        $this->assertCount(4, $game->dealer_hand);
        $this->assertCount(52, $game->deck->cards);
        $dealer->hitDealerOrStand();
        $this->assertCount(4, $game->dealer_hand);
        $this->assertCount(52, $game->deck->cards);
    }

    public function testHitDealerUntilStand_JustOne()
    {
        $game = factory(Game::class)->create();
        $game->dealer_hand = ['4H', '4D', '4S', '4C'];
        $dealer = new Dealer($game);

        $this->assertCount(4, $game->dealer_hand);
        $this->assertCount(52, $game->deck->cards);
        $dealer->hitDealerUntilStand();
        $this->assertCount(5, $game->dealer_hand);
        $this->assertCount(51, $game->deck->cards);
    }

    /**
     * All the cards in this deck are worth 10, so two should be enough to make
     * hitDealerUntilStand go over its threshold
     */
    public function testHitDealerUntilStand_ExactlyTwo()
    {
        $game = factory(Game::class)->create();
        // 48 cards is sufficient to make sure the deck doesn't poop out and say
        // it's too low
        $game->deck->cards = [
            'JH', 'JD', 'JS', 'JC', 'JH', 'JD', 'JS', 'JC', 'JH', 'JD', 'JS', 'JC', 
            'JH', 'JD', 'JS', 'JC', 'JH', 'JD', 'JS', 'JC', 'JH', 'JD', 'JS', 'JC', 
            'JH', 'JD', 'JS', 'JC', 'JH', 'JD', 'JS', 'JC', 'JH', 'JD', 'JS', 'JC', 
            'JH', 'JD', 'JS', 'JC', 'JH', 'JD', 'JS', 'JC', 'JH', 'JD', 'JS', 'JC', 
        ];
        $game->dealer_hand = [];
        $dealer = new Dealer($game);

        $this->assertCount(0, $game->dealer_hand);
        $this->assertCount(48, $game->deck->cards);
        $dealer->hitDealerUntilStand();
        $this->assertCount(2, $game->dealer_hand);
        $this->assertCount(46, $game->deck->cards);
    }

    public function testHitDealerUntilStand_NoMore()
    {
        $game = factory(Game::class)->create();
        $game->deck->cards = [];
        $game->dealer_hand = [];
        $dealer = new Dealer($game);

        $this->assertCount(0, $game->dealer_hand);
        $this->assertCount(0, $game->deck->cards);
        $dealer->hitDealerUntilStand();
        $this->assertCount(0, $game->dealer_hand);
        $this->assertCount(0, $game->deck->cards);
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

        $dealer = new Dealer($game);
        $dealer->deal();
        $this->assertCount(2, $game->dealer_hand);
        $this->assertCount(2, $game->player_hand);
        $this->assertCount(38, $game->deck->cards);
        $this->assertNull($game->winner);
    }
}

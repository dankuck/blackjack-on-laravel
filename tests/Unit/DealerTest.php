<?php

namespace Tests\Unit;

use App\Libs\Dealer;
use App\Models\Game;

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
        $this->markTestIncomplete();
        $game = factory(Game::class)->create();
        $game->dealer_hand = ['QH', 'KH'];
        $dealer = new Dealer($game);

        $this->assertCount(2, $game->dealer_hand);
        $this->assertCount(52, $game->deck->cards);
        $dealer->hitDealerOrStand();
        $this->assertCount(2, $game->dealer_hand);
        $this->assertCount(52, $game->deck->cards);
    }
}

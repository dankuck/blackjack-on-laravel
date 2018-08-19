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
}

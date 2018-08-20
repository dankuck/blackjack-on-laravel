<?php

namespace Tests\Unit;

use App\Listeners\GameEnder;
use App\Events\LowDeck;
use App\Models\Game;

class GameEnderTest extends \Tests\TestCase
{
    public function testExists()
    {
        new GameEnder();
    }

    public function testHandle()
    {
        $game = factory(Game::class)->create();
        $ender = new GameEnder();
        $ender->handle(new LowDeck($game->deck));
        $game = $game->fresh();
        $this->assertTrue((bool)$game->winner);
    }
}

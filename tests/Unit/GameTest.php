<?php

namespace Tests\Unit;

use App\Models\Game;

class GameTest extends \Tests\TestCase
{
    public function testExists()
    {
        $game = Game::create();
        $this->assertNotNull($game);
    }
}

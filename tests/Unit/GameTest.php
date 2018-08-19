<?php

namespace Tests;

use App\Models\Game;

class GameTest extends TestCase
{
    public function testExists()
    {
        $game = Game::create();
        $this->assertNotNull($game);
    }
}

<?php

namespace Tests;

use App\Model\Games;

class GameTest extends TestCase
{
    public function testExists()
    {
        $game = Game::create();
        $this->assertNotNull($game);
    }
}

<?php

namespace Tests\Unit;

use App\Events\LowDeck;
use App\Models\Deck;

class LowDeckTest extends \Tests\TestCase
{
    public function testExists()
    {
        new LowDeck(new Deck());
    }
}

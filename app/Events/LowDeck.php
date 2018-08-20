<?php

namespace App\Events;

use App\Models\Deck;

class LowDeck
{
    public $deck;

    public function __construct(Deck $deck)
    {
        $this->deck = $deck;
    }
}

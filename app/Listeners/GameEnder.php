<?php

namespace App\Listeners;

use App\Events\LowDeck;

class GameEnder
{
    public function handle(LowDeck $event)
    {
        $event->deck->game->decideWinner();
    }
}

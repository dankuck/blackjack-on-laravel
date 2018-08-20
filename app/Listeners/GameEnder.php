<?php

namespace App\Listeners;

use App\Events\LowDeck;

class GameEnder
{
    public function handle(LowDeck $event)
    {
        if ($event->deck->game) {
            $event->deck->game->decideWinner();
        }
    }
}

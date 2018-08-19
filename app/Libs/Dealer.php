<?php

namespace App\Libs;

use App\Models\Game;

class Dealer
{

    private $game;

    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    public function hitPlayer()
    {
        $this->game->player_hand = collect($this->game->player_hand)->merge($this->game->deck->take());
    }

    public function hitDealerOrStand()
    {
        $this->hitDealer();
    }

    private function hitDealer()
    {
        $this->game->dealer_hand = collect($this->game->dealer_hand)->merge($this->game->deck->take());
    }
}

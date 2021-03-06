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
        $this->game->save();
        $this->game->deck->save();
    }

    public function dealerShouldStand()
    {
        return collect($this->game->dealer_hand_values)
            ->filter(function ($value) {
                return $value <= 16;
            })
            ->count() == 0;
    }

    public function hitDealerOrStand()
    {
        if (!$this->dealerShouldStand()) {
            $this->hitDealer();
        }
    }

    private function hitDealer()
    {
        $this->game->dealer_hand = collect($this->game->dealer_hand)->merge($this->game->deck->take());
        $this->game->save();
        $this->game->deck->save();
    }

    public function hitDealerUntilStand()
    {
        while (!$this->dealerShouldStand() && !$this->game->deck->is_done) {
            $this->hitDealer();
        }
    }

    public function deal()
    {
        $this->game->update([
            'player_hand' => $this->game->deck->take(2),
            'dealer_hand' => $this->game->deck->take(2),
            'winner'      => null,
        ]);
        $this->game->deck->save();
    }
}

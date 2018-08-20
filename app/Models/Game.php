<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libs\Hand;

class Game extends Model
{

    const PLAYER = 'PLAYER';
    const DEALER = 'DEALER';
    const TIE    = 'TIE';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'player_hand' => 'array',
        'dealer_hand' => 'array',
    ];

    public static function boot()
    {
        self::creating(function (self $game) {
            if (!$game->player_hand) {
                $game->player_hand = [];
            }
            if (!$game->dealer_hand) {
                $game->dealer_hand = [];
            }
        });
    }

    public function deck()
    {
        return $this->belongsTo(Deck::class);
    }

    public function getDealerHandValuesAttribute()
    {
        return (new Hand($this->dealer_hand))->values();
    }

    public function getDealerHandBestValueAttribute()
    {
        return (new Hand($this->dealer_hand))->bestValue();
    }

    public function getPlayerHandBestValueAttribute()
    {
        return (new Hand($this->player_hand))->bestValue();
    }

    public function decideWinner()
    {
        if ($this->player_hand_best_value > $this->dealer_hand_best_value) {
            $this->winner = self::PLAYER;
            $this->player_wins++;
        } else if ($this->player_hand_best_value < $this->dealer_hand_best_value) {
            $this->winner = self::DEALER;
            $this->dealer_wins++;
        } else {
            $this->winner = self::TIE;
        }
        $this->save();
    }
}

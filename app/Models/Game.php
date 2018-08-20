<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libs\Hand;

class Game extends Model
{
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
            $game->player_hand = [];
            $game->dealer_hand = [];
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
}

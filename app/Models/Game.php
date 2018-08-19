<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}

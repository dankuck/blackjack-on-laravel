<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libs\Card;

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
        $values = [0];
        foreach ($this->dealer_hand as $card) {
            $values = (new Card($card))->addValues($values);
        }
        return $values;
    }
}

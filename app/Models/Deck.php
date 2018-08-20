<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deck extends Model
{
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'cards' => 'array',
    ];

    public static function boot()
    {
        self::creating(function (self $deck) {
            $cards = [];
            foreach (['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'] as $face) {
                foreach (['S', 'C', 'H', 'D'] as $suit) {
                    $cards[] = "{$face}{$suit}";
                }
            }
            $deck->cards = collect($cards)->shuffle();
        });
    }

    public function getCardCountAttribute()
    {
        return count($this->cards);
    }

    public function take($n = 1)
    {
        $cards = collect($this->cards);
        $taken = $cards->splice(0, $n);
        $this->cards = $cards;
        return $taken;
    }

    public function done()
    {
        return !$this->cards;
    }
}

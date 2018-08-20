<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use App\Events\LowDeck;

class Deck extends Model
{
    const SIZE = 52;
    const LOW_THRESHOLD = .4;

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

        self::saved(function (self $deck) {
            if ($deck->card_count <= self::SIZE * self::LOW_THRESHOLD) {
                Event::fire(new LowDeck($deck));
            }
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

    public function game()
    {
        return $this->hasOne(Game::class);
    }
}

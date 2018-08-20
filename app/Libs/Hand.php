<?php

namespace App\Libs;

class Hand
{
    private $cards;

    public function __construct(array $cards)
    {
        $this->cards = $cards;
    }

    public function values()
    {
        $values = [0];
        foreach ($this->cards as $card) {
            $values = (new Card($card))->addValues($values);
        }
        return $values;
    }

    public function bestValue()
    {
        return collect($this->values())
            ->filter(function ($value) {
                return $value <= 21;
            })
            ->sort()
            ->reverse()
            ->first() ?: 0;
    }
}

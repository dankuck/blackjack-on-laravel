<?php

namespace App\Libs;

class Card
{
    private $card;

    public function __construct(string $card)
    {
        $this->card = $card;
    }

    public function values()
    {
        $face = substr($this->card, 0, strlen($this->card) - 1);
        if (is_numeric($face)) {
            return [$face];
        } else {
            switch ($face) {
                case 'J':
                case 'Q':
                case 'K':
                    return [10];
                case 'A':
                    return [1, 11];
                default:
                    throw new \Exception("Unknown value for card: {$card}");
            }
        }
    }

    public function addValues(array $values)
    {
        $result = [];
        foreach ($this->values() as $valueA) {
            foreach ($values as $valueB) {
                $result[] = $valueA + $valueB;
            }
        }
        return $result;
    }
}

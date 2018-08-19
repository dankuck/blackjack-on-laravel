<?php

namespace Tests\Unit;

use App\Libs\Card;
use App\Models\Deck;

class CardTest extends \Tests\TestCase
{
    public function testExists()
    {
        new Card('2H');
    }

    public function testValues()
    {
        foreach (['H', 'C', 'S', 'D'] as $suit) {
            foreach ([2, 3, 4, 5, 6, 7, 8, 9, 10] as $value) {
                $card = new Card("{$value}{$suit}");
                $this->assertEquals([$value], $card->values(), "Using {$value}{$suit}");
            }
            foreach (['J', 'Q', 'K'] as $face) {
                $card = new Card("{$value}{$suit}");
                $this->assertEquals([10], $card->values(), "Using {$value}{$suit}");
            }
            $ace = new Card("A{$suit}");
            $this->assertEquals([1, 11], $ace->values(), "Using A{$suit}"); 
        }
    }

    public function testAddValues_Simple()
    {
        $faces = [
            2 => 2,
            3 => 3,
            4 => 4,
            5 => 5,
            6 => 6,
            7 => 7,
            8 => 8,
            9 => 9,
            10 => 10,
            'J' => 10,
            'Q' => 10,
            'K' => 10,
        ];
        $suits = ['H', 'C', 'S', 'D'];

        // lets just try 10 random pairings
        for ($i = 0; $i < 10; $i++) {
            $face1 = array_rand($faces);
            $face2 = array_rand($faces);
            $value = $faces[$face1] + $faces[$face2];

            $suit1 = $suits[array_rand($suits)];
            $suit2 = $suits[array_rand($suits)];

            $card1 = new Card("{$face1}{$suit1}");
            $card2 = new Card("{$face2}{$suit2}");
            $this->assertEquals([$value], $card1->addValues($card2->values()), "Using {$face1}{$suit1} and {$face2}{$suit2}");
            $this->assertEquals([$value], $card2->addValues($card1->values()), "Using {$face1}{$suit1} and {$face2}{$suit2} backwards");
        }
    }

    public function testAddValues_Aces()
    {
        $faces = [
            2 => 2,
            3 => 3,
            4 => 4,
            5 => 5,
            6 => 6,
            7 => 7,
            8 => 8,
            9 => 9,
            10 => 10,
            'J' => 10,
            'Q' => 10,
            'K' => 10,
        ];
        $suits = ['H', 'C', 'S', 'D'];

        // lets just try 10 random pairings
        for ($i = 0; $i < 10; $i++) {
            $face1 = array_rand($faces);
            $value = $faces[$face1];

            $suit1 = $suits[array_rand($suits)];
            $suit2 = $suits[array_rand($suits)];

            $card1 = new Card("{$face1}{$suit1}");
            $ace = new Card("A{$suit2}");
            $this->assertEquals([$value + 1, $value + 11], $card1->addValues($ace->values()), "Using {$face1}{$suit1} and A{$suit2}");
            $this->assertEquals([$value + 1, $value + 11], $ace->addValues($card1->values()), "Using {$face1}{$suit1} and A{$suit2} backwards");
            $this->assertEquals([1 + 1, 1 + 11, 11 + 1, 11 + 11], $ace->addValues($ace->values()), "Using A{$suit2} and A{$suit2}");
        }
    }
}

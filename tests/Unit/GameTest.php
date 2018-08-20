<?php

namespace Tests\Unit;

use App\Models\Game;
use App\Models\Deck;

class GameTest extends \Tests\TestCase
{
    public function testExists()
    {
        new Game();
    }

    public function testDeck()
    {
        $deck = Deck::create();
        $game = Game::create(['deck_id' => $deck->id]);
        $this->assertEquals($deck->id, $game->deck->id);
    }

    public function testPlayerHand()
    {
        $game = factory(Game::class)->create();
        $this->assertCount(0, $game->player_hand);

        $game->player_hand = Deck::create()->cards;
        $game->save();
        $this->assertCount(52, $game->player_hand);
    }

    public function testDealerHand()
    {
        $game = factory(Game::class)->create();
        $this->assertCount(0, $game->dealer_hand);

        $game->dealer_hand = Deck::create()->cards;
        $game->save();
        $this->assertCount(52, $game->dealer_hand);
    }

    public function testDealerHandValues()
    {
        $game = factory(Game::class)->create();
        $game->dealer_hand = ['AH', 'AH'];
        $this->assertEquals([1 + 1, 1 + 11, 11 + 1, 11 + 11], $game->dealer_hand_values);
    }

    public function testDealerHandBestValue()
    {
        $game = factory(Game::class)->create();
        $game->dealer_hand = ['AH', 'AH'];
        $this->assertEquals(12, $game->dealer_hand_best_value);
    }

    public function testPlayerHandBestValue()
    {
        $game = factory(Game::class)->create();
        $game->player_hand = ['AH', 'AH'];
        $this->assertEquals(12, $game->player_hand_best_value);
    }

    public function testDecideWinner()
    {
        $game = factory(Game::class)->create();
        $this->assertNull($game->winner);

        $game->player_hand = ['AH', 'QH']; // 21
        $game->dealer_hand = ['QH', 'QS']; // 20
        $game->decideWinner();
        $this->assertEquals(Game::PLAYER, $game->winner);
        $this->assertEquals(1, $game->player_wins);

        $game->player_hand = ['QH', 'QS']; // 20
        $game->dealer_hand = ['AH', 'QH']; // 21
        $game->decideWinner();
        $this->assertEquals(Game::DEALER, $game->winner);
        $this->assertEquals(1, $game->dealer_wins);

        $game->player_hand = ['QH', 'AH']; // 21
        $game->dealer_hand = ['AH', 'QH']; // 21
        $game->decideWinner();
        $this->assertEquals(Game::TIE, $game->winner);
        $this->assertEquals(1, $game->player_wins);
        $this->assertEquals(1, $game->dealer_wins);
    }
}

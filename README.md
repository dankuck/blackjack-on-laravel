# blackjack-on-laravel
A blackjack game driven by Laravel

# Specification

 The game will have 1 standard deck of 52 cards.
 The game will have 4 controls:

  * New Game
  * Hit
  * Stand
  * Deal

 The game should continue until 60% of the cards have been used. Upon reaching that point the game will end. The game
 will keep track of how many hands were won and lost by the player.

 To begin with the dealer and player will receive 2 cards. The player has the option to "Hit" or "Stand".
 Once the player stands the dealer will play out his hand.

 The dealer must hit at 16 or lower. And must stand on 17 and above.

# Installation

To run the application:

```bash
git clone https://github.com/dankuck/blackjack-on-laravel.git
cd blackjack-on-laravel
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
```

You're all set. Visit /.

To run tests, follow these further instructions:

```bash
touch database/testing.sqlite
phpunit
```

# Choices

I chose to use a SQLite server because it is portable, and NoSQL alternatives are not representative of the most common Laravel usage.

I chose to make the test files in a shallow directory structure because that's easy to inspect. Normally, you'd lay them out in a directory structure mirroring the structure of the code under test.

In order to make this a good example of Laravel and not a good example of frontend frameworks, I chose to rely primarily on Blade templates with forms. Unfortunately this meant I couldn't make a good example of RESTful approaches.

I chose not to implement any user or auth stuff. E.g., anyone can access any game.

I found a sprite map of cards on the Internet. It has unknown copyright status.

I tried to show a variety of implementation options in the data structure. If I were to continue developing this, I can think of some data that I would refactor from a JSON column into a first-class Model.

I chose to use a first-class event in the game ending code in order to show how events are used.

# Files Worth Looking At

 * <a href="https://github.com/dankuck/blackjack-on-laravel/blob/master/app/Events/LowDeck.php">app/Events/LowDeck.php</a>
 * <a href="https://github.com/dankuck/blackjack-on-laravel/blob/master/app/Http/Controllers/GameController.php">app/Http/Controllers/GameController.php</a>
 * <a href="https://github.com/dankuck/blackjack-on-laravel/blob/master/app/Libs/Card.php">app/Libs/Card.php</a>
 * <a href="https://github.com/dankuck/blackjack-on-laravel/blob/master/app/Libs/Dealer.php">app/Libs/Dealer.php</a>
 * <a href="https://github.com/dankuck/blackjack-on-laravel/blob/master/app/Libs/Hand.php">app/Libs/Hand.php</a>
 * <a href="https://github.com/dankuck/blackjack-on-laravel/blob/master/app/Listeners/GameEnder.php">app/Listeners/GameEnder.php</a>
 * <a href="https://github.com/dankuck/blackjack-on-laravel/blob/master/app/Models/Deck.php">app/Models/Deck.php</a>
 * <a href="https://github.com/dankuck/blackjack-on-laravel/blob/master/app/Models/Game.php">app/Models/Game.php</a>
 * <a href="https://github.com/dankuck/blackjack-on-laravel/blob/master/app/Providers/EventServiceProvider.php">app/Providers/EventServiceProvider.php</a>
 * <a href="https://github.com/dankuck/blackjack-on-laravel/blob/master/database/factories/ModelFactory.php">database/factories/ModelFactory.php</a>
 * <a href="https://github.com/dankuck/blackjack-on-laravel/blob/master/database/migrations/2018_08_19_000000_create_decks_table.php">database/migrations/2018_08_19_000000_create_decks_table.php</a>
 * <a href="https://github.com/dankuck/blackjack-on-laravel/blob/master/database/migrations/2018_08_19_000000_create_games_table.php">database/migrations/2018_08_19_000000_create_games_table.php</a>
 * <a href="https://github.com/dankuck/blackjack-on-laravel/blob/master/resources/assets/js/app.js">resources/assets/js/app.js</a>
 * <a href="https://github.com/dankuck/blackjack-on-laravel/blob/master/resources/assets/js/components/Card.vue">resources/assets/js/components/Card.vue</a>
 * <a href="https://github.com/dankuck/blackjack-on-laravel/blob/master/resources/views/dev/card-deck.blade.php">resources/views/dev/card-deck.blade.php</a>
 * <a href="https://github.com/dankuck/blackjack-on-laravel/blob/master/resources/views/game/no-show.blade.php">resources/views/game/no-show.blade.php</a>
 * <a href="https://github.com/dankuck/blackjack-on-laravel/blob/master/resources/views/game/show.blade.php">resources/views/game/show.blade.php</a>
 * <a href="https://github.com/dankuck/blackjack-on-laravel/blob/master/resources/views/layout.blade.php">resources/views/layout.blade.php</a>
 * <a href="https://github.com/dankuck/blackjack-on-laravel/blob/master/resources/views/start.blade.php">resources/views/start.blade.php</a>
 * <a href="https://github.com/dankuck/blackjack-on-laravel/blob/master/routes/web.php">routes/web.php</a>
 * <a href="https://github.com/dankuck/blackjack-on-laravel/blob/master/tests/Feature/GameControllerTest.php">tests/Feature/GameControllerTest.php</a>
 * <a href="https://github.com/dankuck/blackjack-on-laravel/blob/master/tests/Unit/CardTest.php">tests/Unit/CardTest.php</a>
 * <a href="https://github.com/dankuck/blackjack-on-laravel/blob/master/tests/Unit/DealerTest.php">tests/Unit/DealerTest.php</a>
 * <a href="https://github.com/dankuck/blackjack-on-laravel/blob/master/tests/Unit/DeckTest.php">tests/Unit/DeckTest.php</a>
 * <a href="https://github.com/dankuck/blackjack-on-laravel/blob/master/tests/Unit/GameEnderTest.php">tests/Unit/GameEnderTest.php</a>
 * <a href="https://github.com/dankuck/blackjack-on-laravel/blob/master/tests/Unit/GameTest.php">tests/Unit/GameTest.php</a>
 * <a href="https://github.com/dankuck/blackjack-on-laravel/blob/master/tests/Unit/HandTest.php">tests/Unit/HandTest.php</a>
 * <a href="https://github.com/dankuck/blackjack-on-laravel/blob/master/tests/Unit/LowDeckTest.php">tests/Unit/LowDeckTest.php</a>

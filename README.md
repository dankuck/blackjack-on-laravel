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

You're all set, visit /.

To run tests, follow these further instructions:

```bash
touch database/testing.sqlite
phpunit
```

# Choices

I chose to use a SQLite server because it is portable and NoSQL alternatives are not representative of the most common Laravel usage.

I chose to make the test files in a flat directory structure because that's easier to read and it would only cause a mess if someone wanted to continue developing this software.

In order to make this a good example of Laravel and not a good example of frontend frameworks, I chose to rely primarily on Blade templates with forms. Unfortunately this meant I couldn't exemplify RESTful approaches. I chose to make best use of HTTP verbs anyway.

I chose not to implement any user-based auth stuff. E.g., anyone can access any game.

I found a sprite map of cards on the Internet. It has unknown copyright status.

I tried to show variety of implementation options. If I were to continue developing this, I can think of some data that I would refactor out from a JSON column into a first class Model.

I chose to handle the game-ending state as a first-class event so that it would show that system.


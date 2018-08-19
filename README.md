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

# Choices

I chose to use a SQLite server because it is portable and NoSQL alternatives are not representative of the most common Laravel usage.


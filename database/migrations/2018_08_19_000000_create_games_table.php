<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->integer('id', true);
            $table->timestamps();
            $table->integer('deck_id');
            $table->text('player_hand');
            $table->text('dealer_hand');
            $table->string('winner')->nullable();
            $table->integer('player_wins')->default(0);
            $table->integer('dealer_wins')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}

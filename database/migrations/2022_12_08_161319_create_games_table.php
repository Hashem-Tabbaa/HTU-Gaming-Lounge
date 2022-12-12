<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id()->autoIncrement();
            $table->string('name');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('session_duration');
            $table->timestamps();
        });

        DB::table('games')->insert([
            ['name' => 'Billiard', 'start_time' => '08:30', 'end_time' => '17:30', 'session_duration' => 30],
            ['name' => 'PS5', 'start_time' => '08:30', 'end_time' => '17:30', 'session_duration' => 30],
            ['name' => 'Air-Hockey', 'start_time' => '08:30', 'end_time' => '17:30', 'session_duration' => 30],
            ['name' => 'Ping-Pong', 'start_time' => '08:30', 'end_time' => '17:30', 'session_duration' => 30],
            ['name' => 'Baby-Football', 'start_time' => '08:30', 'end_time' => '17:30', 'session_duration' => 30]
        ]);
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
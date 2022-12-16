<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
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
            $table->string('name')->primary();
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('session_duration');
            $table->integer('sessions_capacity')->nullable();
            $table->timestamps();
        });

        DB::table('games')->insert([
            ['name' => 'Billiard', 'start_time' => '08:30', 'end_time' => '17:30', 'session_duration' => 30, 'sessions_capacity' => 1],
            ['name' => 'Air-Hockey', 'start_time' => '08:30', 'end_time' => '17:30', 'session_duration' => 30, 'sessions_capacity' => 1],
            ['name' => 'PS5', 'start_time' => '08:30', 'end_time' => '17:30', 'session_duration' => 30, 'sessions_capacity' => 3],
            ['name' => 'Ping-Pong', 'start_time' => '08:30', 'end_time' => '17:30', 'session_duration' => 30, 'sessions_capacity' => 1],
            ['name' => 'Baby-Football', 'start_time' => '08:30', 'end_time' => '17:30', 'session_duration' => 30, 'sessions_capacity' => 1]
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

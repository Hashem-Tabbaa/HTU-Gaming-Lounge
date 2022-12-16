<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('game_name');
            $table->time('res_time');
            $table->time('res_end_time');
            $table->string('student1_email');
            $table->string('student2_email')->nullable();
            $table->string('student3_email')->nullable();
            $table->string('student4_email')->nullable();
            $table->foreign('game_name')->references('name')->on('games');
            $table->foreign('student1_email')->references('email')->on('users');
            $table->foreign('student2_email')->references('email')->on('users');
            $table->foreign('student3_email')->references('email')->on('users');
            $table->foreign('student4_email')->references('email')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}

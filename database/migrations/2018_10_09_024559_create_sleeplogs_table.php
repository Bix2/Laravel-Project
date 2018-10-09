<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSleeplogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sleeplogs', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date_of_sleep');
            $table->integer('deep_minutes');
            $table->integer('light_minutes');
            $table->integer('rem_minutes');
            $table->integer('wake_minutes');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('sleeplogs');
    }
}

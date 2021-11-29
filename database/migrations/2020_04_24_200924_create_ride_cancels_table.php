<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRideCancelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ride_cancels', function (Blueprint $table) {
            $table->id();
            $table->integer('cabride_id');
            $table->integer('driver_id');
            $table->integer('passenger_id');
            $table->dateTime('cancel_time');
            $table->string('ridestatus_id', 30);
            $table->string('cancel_issue');
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
        Schema::dropIfExists('ride_cancels');
    }
}

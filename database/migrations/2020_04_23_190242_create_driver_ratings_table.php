<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_ratings', function (Blueprint $table) {
            $table->id();
            $table->integer('ride_id');
            $table->integer('driver_id')->nullable();
            $table->integer('passenger_id')->nullable();
            $table->integer('rating_value')->nullable()->default(0);
         
            $table->text('note');
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
        Schema::dropIfExists('driver_ratings');
    }
}

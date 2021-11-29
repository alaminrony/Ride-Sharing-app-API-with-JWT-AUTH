<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCabsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cabs', function (Blueprint $table) {
            $table->id();
            $table->string('photo')->nullable();
            $table->string('manufacturer');
            $table->string('model_number')->nullable();
            $table->string('manufacturer_year');
            $table->string('color');
            $table->integer('cabtype_id')->nullable();
            $table->string('number_plate')->nullable();
            $table->string('taxi_operator');
            $table->integer('passenger_capacity');
            $table->boolean('children');
            $table->boolean('wheelchair');
            $table->integer('driver_id')->nullable();
            $table->text('description')->nullable();
          
            $table->integer('created_by');
            $table->integer('updated_by');
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
        Schema::dropIfExists('cabs');
    }
}

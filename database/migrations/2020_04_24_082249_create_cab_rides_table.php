<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCabRidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cab_rides', function (Blueprint $table) {
            $table->id();
            $table->integer('passenger_id')->nullable();
            // $table->string('adult_type')->nullable();
            $table->string('adult_number')->nullable();
            $table->boolean('has_children')->nullable();
            $table->string('children_number')->nullable();
            $table->boolean('has_wheelchair');
            $table->string('wheelchair_number')->nullable();
            $table->integer('driver_id')->nullable();
            $table->string('ride_type')->nullable();
            $table->integer('cab_id')->nullable();
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            // $table->integer('complete')->nullable();
            $table->double('riding_distance',4,2)->nullable();
            $table->string('pickup_address')->nullable();
            $table->string('pickup_latitude')->nullable();
            $table->string('pickup_longitude')->nullable();
            $table->string('destination_latitude')->nullable();
            $table->string('destination_longitude')->nullable();
            $table->string('destination_address')->nullable();
            // $table->dateTime('canceled');
            $table->string('cancel_issue');
            $table->integer('canceled_by');
            $table->integer('ridestatus_id');
            // $table->integer('driver_plan_id');
            // $table->integer('discount_it');
            // $table->string('discount_percent')->nullable();
            $table->string('bid_amount')->nullable();
            $table->string('total_fare_amount')->nullable();
            $table->string('charge_amount')->nullable();
            $table->integer('charge_type')->nullable();
            $table->tinyInteger('charge_status')->nullable();
            $table->text('comment');
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
        Schema::dropIfExists('cab_rides');
    }
}

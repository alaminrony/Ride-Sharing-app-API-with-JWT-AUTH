<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverDailySummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_daily_summaries', function (Blueprint $table) {
            $table->id();
            $table->integer('driver_id')->nullable();
            $table->integer('total_minutes')->nullable();
            $table->string('last_status')->nullable();
            $table->integer('charge_type')->nullable();
            $table->double('charge_amount',4,2)->nullable();
            $table->integer('payment_status')->nullable();
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
        Schema::dropIfExists('driver_daily_summaries');
    }
}

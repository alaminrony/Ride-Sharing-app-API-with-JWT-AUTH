<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('country_id');
            $table->tinyInteger('billchargeoption_id');
            $table->tinyInteger('billchargeoptionvalue_id');
            $table->float('charge_value')->nullable();
            $table->integer('bill_days')->nullable();
            $table->integer('tryal_period')->nullable();
            $table->integer('ride_request_cancel_time')->nullable();
            $table->integer('driver_fine_over_time')->nullable();
            $table->integer('driver_fine_amount')->nullable();
            $table->integer('passenger_fine_over_time')->nullable();
            $table->integer('passenger_fine_amount')->nullable();
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
        Schema::dropIfExists('bill_settings');
    }
}

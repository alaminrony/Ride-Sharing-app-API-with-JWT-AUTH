<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_bills', function (Blueprint $table) {
            $table->id();
            $table->integer('transaction_id')->nullable();
            $table->integer('driver_id')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date');
            $table->double('amount',6,2);
            $table->integer('billchargeoption_id')->nullable();
            $table->integer('billchargeoptionvalue_id')->nullable();
            $table->tinyInteger('payment_status')->nullable();
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
        Schema::dropIfExists('driver_bills');
    }
}

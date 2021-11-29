<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverPaymentInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_payment_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('driver_id')->nullable();
            // $table->text('bank')->nullable();
            $table->text('cc_info')->nullable();
            $table->string('stripe_profile_id')->nullable();
            $table->double('amount')->nullable();

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
        Schema::dropIfExists('driver_payment_infos');
    }
}

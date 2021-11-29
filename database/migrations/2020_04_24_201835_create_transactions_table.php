<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('driver_id')->nullable();
            $table->string('stripe_profile_id')->nullable();
            $table->string('currency')->nullable();
            $table->double('amount')->nullable();

            // $table->string('transaction_code', 100)->nullable();
            // $table->string('email', 100)->nullable();
            // $table->string('type', 10)->nullable()->comment('driver , passenger');
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePassengersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passengers', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('gender')->nullable();
            $table->string('address');
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('post_code')->nullable();
            $table->string('avatar')->nullable();
            $table->string('phone_verification', 25)->nullable();
            $table->integer('phone_verification_status')->nullable()->default(0);
            $table->string('mail_verification', 25)->nullable();
            $table->integer('mail_verification_status')->nullable()->default(0);
            $table->string('password')->nullable();
            $table->string('provider_id')->nullable();
            $table->string('access_token')->nullable();
            $table->string('saved_home_address')->nullable();
            $table->string('saved_work_address')->nullable();
            $table->boolean('active')->nullable()->default(1);
            $table->boolean('trash_status')->default(0);
            $table->ipAddress('last_ip_address')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->integer('last_login')->unsigned()->nullable();
            $table->decimal('point')->nullable()->default(0.00);
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('passengers');
    }
}

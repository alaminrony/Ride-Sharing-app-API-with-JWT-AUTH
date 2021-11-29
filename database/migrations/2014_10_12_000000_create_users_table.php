<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->ipAddress('last_ip_address', 45)->nullable();
            $table->ipAddress('ip_address', 45)->nullable();
           
            $table->string('activation_code', 40)->nullable();
            // $table->string('forgotten_password_code', 40)->nullable();
            // $table->integer('forgotten_password_time')->unsigned()->nullable();
            // $table->string('remember_code', 40)->nullable();
            $table->integer('last_login')->unsigned()->nullable();
            $table->boolean('active')->nullable();
            $table->string('first_name', 50)->nullable();
            $table->string('last_name', 50)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('avatar', 55)->nullable();
            $table->string('gender', 20)->nullable();
            $table->integer('group_id')->unsigned()->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('status');
            $table->timestamp('email_verified_at')->nullable();
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
        Schema::dropIfExists('users');
    }
}

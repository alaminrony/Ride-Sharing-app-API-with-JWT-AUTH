<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {



        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->nullable();
            $table->string('email');
            $table->string('phone');
            $table->string('gender')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('profile_photo')->nullable();
            $table->string('driving_licence_no');
            $table->date('driving_licence_expire_date')->nullable();
            $table->string('driving_licence_photo_front')->nullable();
            $table->string('driving_licence_photo_back')->nullable();
            $table->string('australian_taxi_licence_no');
            $table->date('australian_taxi_licence_expire_date')->nullable();
            $table->string('atln_photo_front')->nullable();
            $table->string('atln_photo_back')->nullable();
            $table->string('phone_varification')->nullable();
            $table->string('phone_varification_status')->nullable();
            $table->string('mail_verification', 25)->nullable();
            $table->integer('mail_verification_status')->nullable()->default(0);
            $table->string('password');
            $table->integer('driver_type_id');
            $table->integer('cab_id');
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('post_code')->nullable();
            $table->text('address')->nullable();
            $table->string('pin')->nullable();
            $table->string('provider_id')->nullable();
            $table->string('access_token')->nullable();
            $table->decimal('d_point',10, 2);
            $table->decimal('rating_value',10, 2);
            $table->ipAddress('last_ip_address')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->dateTime('last_login')->nullable(); //strtotimetime
            $table->tinyInteger('active')->nullable()->default(1);
            $table->integer('is_online');
            $table->integer('trash_status');
            $table->string('current_location_gps')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by');

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
        Schema::dropIfExists('drivers');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo');
            $table->string('site_name', 55);
            $table->string('tel', 20);
            $table->string('dateformat', 20)->nullable();
            $table->string('timeformat', 20)->nullable();
            $table->string('default_email', 100);
            $table->string('version', 5)->default('1.0');
            $table->string('frontend_theme', 38);
            $table->string('theme', 20);
            $table->string('timezone')->default('0');
            $table->string('protocol', 10);
            $table->string('gps_key');
            $table->boolean('mmode');
            $table->boolean('captcha')->default(1);
            $table->string('mailpath', 55)->nullable();
            $table->integer('rows_per_page');
            $table->integer('total_rows');
            $table->boolean('bsty');
            $table->boolean('pro_limit');
            $table->boolean('decimals')->default(2);
            $table->string('thousands_sep', 2)->default(',');
            $table->string('decimals_sep', 2)->default('.');
            $table->string('focus_add_item', 55)->nullable();
            $table->string('finalize_sale', 55)->nullable();
            $table->string('receipt_printer', 55)->nullable();
            $table->boolean('rounding')->nullable()->default(0);
            $table->string('theme_style', 25)->nullable()->default('green');
            $table->boolean('after_sale_page')->nullable();
            $table->boolean('overselling')->nullable()->default(1);
            $table->boolean('multi_store')->nullable();
            $table->string('language', 50);
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
        Schema::dropIfExists('settings');
    }
}

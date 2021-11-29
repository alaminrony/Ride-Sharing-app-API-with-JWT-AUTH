<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->char('country_code',2);
            $table->string('country_name');
            $table->char('currency_code',3);
            $table->char('fips_code',3);
            $table->char('iso_numeric',4);
            $table->string('north',30);
            $table->string('south',30);
            $table->string('east',30);
            $table->string('west',30);
            $table->string('capital',30);
            $table->string('continent_name',100);
            $table->char('continent',2);
            $table->string('language',100);
            $table->char('iso_alpha3',3);
            $table->integer('geoname_id');
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
        Schema::dropIfExists('countries');
    }
}

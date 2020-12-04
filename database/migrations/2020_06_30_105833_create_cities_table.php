<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('city');
            $table->float('latitude', 10, 6);
            $table->float('longitude', 10, 6);
            $table->point('location', 4326)->nullable();
            $table->string('country');
            $table->string('iso2');
            $table->string('admin');
            $table->string('capital')->nullable();
            $table->string('population')->nullable();
            $table->string('population_proper')->nullable();
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
        Schema::dropIfExists('cities');
    }
}

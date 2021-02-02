<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id');
            $table->foreignId('user_id');
            $table->foreignId('city_id');
            $table->string('title');
            $table->string('slug')->unique()->nullable();
            $table->text('description');
            $table->decimal('price', 8, 2);
            $table->enum('type', ['private', 'business']);
            $table->enum('condition', ['new', 'used']);
            $table->enum('delivery', ['buyer', 'seller', 'personal handover']);
            $table->bigInteger('views')->default(0);
            $table->boolean('featured')->default(false);
            $table->boolean('archived')->default(false);
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ads');
    }
}

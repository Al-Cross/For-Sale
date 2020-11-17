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
            $table->string('name');
            $table->string('email')->unique();
            $table->boolean('confirmed')->default(false);
            $table->enum('type', ['basic', 'advanced', 'premium'])->default('basic'); // added default() because of the registration test
            $table->tinyInteger('ad_limit')->default(3);
            $table->string('password');
            $table->string('email_verified_at')->nullable();
            $table->string('confirmation_token', 25)->nullable();
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone', 20);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->unsignedBigInteger('country_id')->index('users_country_id_foreign');
            $table->unsignedBigInteger('role_id')->index('users_role_id_foreign');
            $table->longText('device_token')->nullable();
            $table->longText('token')->nullable();
            $table->double('wallet', 10, 2)->default(0);
            $table->integer('points')->default(0);
            $table->string('image')->nullable();
            $table->string('link');
            $table->tinyInteger('gender')->nullable();
            $table->string('nationality', 256)->nullable();
            $table->string('birth_date', 256)->nullable();
            $table->tinyInteger('status')->default(0);
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
};

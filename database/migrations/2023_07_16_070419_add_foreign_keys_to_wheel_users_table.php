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
        Schema::table('wheel_users', function (Blueprint $table) {
            $table->foreign(['user_id'], 'wheel_users_ibfk_1')->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['wheel_id'], 'wheel_users_ibfk_2')->references(['id'])->on('wheel_of_fortunes')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wheel_users', function (Blueprint $table) {
            $table->dropForeign('wheel_users_ibfk_1');
            $table->dropForeign('wheel_users_ibfk_2');
        });
    }
};

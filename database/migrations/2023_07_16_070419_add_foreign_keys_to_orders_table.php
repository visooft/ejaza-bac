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
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign(['housings_id'], 'orders_ibfk_1')->references(['id'])->on('housings')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['user_id'], 'orders_ibfk_2')->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_ibfk_1');
            $table->dropForeign('orders_ibfk_2');
        });
    }
};

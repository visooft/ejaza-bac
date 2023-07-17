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
        Schema::table('notifications_detials', function (Blueprint $table) {
            $table->foreign(['notification_id'], 'notifications_detials_ibfk_1')->references(['id'])->on('notifications')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['user_id'], 'notifications_detials_ibfk_2')->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications_detials', function (Blueprint $table) {
            $table->dropForeign('notifications_detials_ibfk_1');
            $table->dropForeign('notifications_detials_ibfk_2');
        });
    }
};

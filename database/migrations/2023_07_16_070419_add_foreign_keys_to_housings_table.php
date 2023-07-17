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
        Schema::table('housings', function (Blueprint $table) {
            $table->foreign(['street_id'])->references(['id'])->on('streets')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['city_id'])->references(['id'])->on('cities')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['category_id'], 'housings_ibfk_2')->references(['id'])->on('categories')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['country_id'], 'housings_ibfk_1')->references(['id'])->on('countries')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('housings', function (Blueprint $table) {
            $table->dropForeign('housings_street_id_foreign');
            $table->dropForeign('housings_city_id_foreign');
            $table->dropForeign('housings_ibfk_2');
            $table->dropForeign('housings_user_id_foreign');
            $table->dropForeign('housings_ibfk_1');
        });
    }
};

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
        Schema::table('accompanyings', function (Blueprint $table) {
            $table->foreign(['house_id'], 'accompanyings_ibfk_1')->references(['id'])->on('housings')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['travel_id'], 'accompanyings_ibfk_2')->references(['id'])->on('travel_types')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accompanyings', function (Blueprint $table) {
            $table->dropForeign('accompanyings_ibfk_1');
            $table->dropForeign('accompanyings_ibfk_2');
        });
    }
};

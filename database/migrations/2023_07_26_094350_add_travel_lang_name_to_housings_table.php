<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTravelLangNameToHousingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('housings', function (Blueprint $table) {
            $table->string('travel_name_en')->nullable();
            $table->string('travel_name_tr')->nullable();
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
            //
        });
    }
}

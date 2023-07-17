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
        Schema::create('accompanyings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('house_id')->index('house_id');
            $table->unsignedBigInteger('travel_id')->index('travel_id');
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
        Schema::dropIfExists('accompanyings');
    }
};

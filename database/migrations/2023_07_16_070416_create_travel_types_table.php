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
        Schema::create('travel_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_ar', 256);
            $table->string('name_en', 256);
            $table->string('name_tr', 256);
            $table->string('type', 256);
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('travel_types');
    }
};

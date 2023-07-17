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
        Schema::create('streets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_ar');
            $table->string('name_en');
            $table->string('name_tr');
            $table->unsignedBigInteger('city_id')->index('streets_city_id_foreign');
            $table->tinyInteger('status')->default(0);
            $table->string('lat', 256)->nullable();
            $table->string('long', 256)->nullable();
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
        Schema::dropIfExists('streets');
    }
};

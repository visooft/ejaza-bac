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
        Schema::create('adspaces', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title_ar', 256);
            $table->string('title_en', 256);
            $table->string('title_tr', 256);
            $table->text('desc_ar');
            $table->text('desc_en');
            $table->text('desc_tr');
            $table->string('image', 256);
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
        Schema::dropIfExists('adspaces');
    }
};

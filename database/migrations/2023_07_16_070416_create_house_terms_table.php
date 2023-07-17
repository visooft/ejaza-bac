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
        Schema::create('house_terms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('desc_ar');
            $table->text('desc_en');
            $table->text('desc_tr');
            $table->unsignedBigInteger('housings_id')->index('house_terms_housings_id_foreign');
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
        Schema::dropIfExists('house_terms');
    }
};

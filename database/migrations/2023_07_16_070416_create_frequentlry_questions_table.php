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
        Schema::create('frequentlry_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title_ar');
            $table->string('title_en');
            $table->string('title_tr');
            $table->text('answer_ar');
            $table->text('answer_en');
            $table->text('answer_tr');
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
        Schema::dropIfExists('frequentlry_questions');
    }
};

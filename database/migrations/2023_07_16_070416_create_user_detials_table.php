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
        Schema::create('user_detials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('id_number');
            $table->string('Residence_permit');
            $table->string('front_photo')->nullable();
            $table->string('back_photo')->nullable();
            $table->string('IBAN', 256)->nullable();
            $table->unsignedBigInteger('user_id')->index('user_detials_user_id_foreign');
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
        Schema::dropIfExists('user_detials');
    }
};

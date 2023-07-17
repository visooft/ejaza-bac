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
        Schema::create('coupons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('coupon');
            $table->string('start');
            $table->string('end', 256);
            $table->integer('count');
            $table->integer('counUsed')->default(0);
            $table->double('offer', 8, 2);
            $table->string('type')->default('percentage');
            $table->unsignedBigInteger('housings_id')->nullable()->index('coupons_housings_id_foreign');
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
        Schema::dropIfExists('coupons');
    }
};

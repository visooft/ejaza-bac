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
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('orderNumber', 20);
            $table->unsignedBigInteger('user_id')->index('user_id');
            $table->unsignedBigInteger('housings_id')->index('house_id');
            $table->string('from', 256)->nullable();
            $table->string('to', 256)->nullable();
            $table->integer('count');
            $table->float('total');
            $table->string('lat', 256)->nullable();
            $table->string('long', 256)->nullable();
            $table->string('date', 256)->nullable();
            $table->string('time', 256)->nullable();
            $table->string('name', 256)->nullable();
            $table->string('email', 256)->nullable();
            $table->string('phone', 256)->nullable();
            $table->string('payment_type', 20);
            $table->tinyInteger('status')->default(0);
            $table->longText('cancel_ar')->nullable();
            $table->string('action_name', 256)->nullable();
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
        Schema::dropIfExists('orders');
    }
};

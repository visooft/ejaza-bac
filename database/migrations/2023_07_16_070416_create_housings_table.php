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
        Schema::create('housings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_ar')->nullable();
            $table->string('name_en')->nullable();
            $table->string('name_tr')->nullable();
            $table->text('desc_ar');
            $table->text('desc_en');
            $table->text('desc_tr');
            $table->string('area', 256)->nullable();
            $table->double('price', 8, 2);
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->unsignedBigInteger('city_id')->nullable()->index('housings_city_id_foreign');
            $table->unsignedBigInteger('country_id')->default(1)->index('country_id');
            $table->unsignedBigInteger('category_id')->index('category_id');
            $table->unsignedBigInteger('street_id')->nullable()->index('housings_street_id_foreign');
            $table->unsignedBigInteger('user_id')->index('housings_user_id_foreign');
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('show')->default(0);
            $table->tinyInteger('hide')->default(0);
            $table->string('language_id', 256)->nullable();
            $table->string('license_number', 256)->nullable();
            $table->unsignedBigInteger('travel_type_id')->nullable();
            $table->unsignedBigInteger('travel_country_id')->nullable();
            $table->tinyInteger('group_travel')->default(0);
            $table->tinyInteger('indivdual_travel')->default(0);
            $table->string('from', 256)->nullable();
            $table->string('to', 256)->nullable();
            $table->string('iban', 256)->nullable();
            $table->string('address', 256)->nullable();
            $table->string('national_image', 256)->nullable();
            $table->string('license_image', 256)->nullable();
            $table->string('car_type', 256)->nullable();
            $table->string('event_name', 256)->nullable();
            $table->string('event_name_en', 256)->nullable();
            $table->string('event_name_tr', 256)->nullable();
            $table->string('car_type_en', 256)->nullable();
            $table->string('car_type_tr', 256)->nullable();
            $table->integer('hour_work')->default(0);
            $table->integer('ticket_count')->default(0);
            $table->integer('hour_price')->default(0);
            $table->string('guide_image', 256)->nullable();
            $table->integer('passengers')->nullable()->default(0);
            $table->string('moodle', 256)->nullable();
            $table->tinyInteger('go')->default(0);
            $table->tinyInteger('back')->default(0);
            $table->integer('count_days')->default(0);
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
        Schema::dropIfExists('housings');
    }
};

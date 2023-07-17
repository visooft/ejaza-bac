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
        Schema::create('house_detials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('families')->default(0);
            $table->tinyInteger('individual')->nullable();
            $table->tinyInteger('insurance')->nullable()->default(0);
            $table->string('insurance_value', 256)->nullable();
            $table->tinyInteger('private_house')->default(0);
            $table->tinyInteger('Shared_accommodation')->default(0);
            $table->tinyInteger('animals')->default(0);
            $table->tinyInteger('visits')->default(0);
            $table->tinyInteger('bed_room')->default(0);
            $table->tinyInteger('Bathrooms')->default(0);
            $table->tinyInteger('council')->default(0);
            $table->tinyInteger('kitchen_table')->default(0);
            $table->unsignedBigInteger('housings_id')->index('house_detials_housings_id_foreign');
            $table->tinyInteger('smoking')->default(0);
            $table->tinyInteger('camp')->default(0);
            $table->tinyInteger('chalets')->default(0);
            $table->tinyInteger('flight_tickets')->default(0);
            $table->tinyInteger('main_meal')->default(0);
            $table->tinyInteger('housing_included')->default(0);
            $table->tinyInteger('Tour_guide_included')->default(0);
            $table->tinyInteger('breakfast')->default(0);
            $table->tinyInteger('lunch')->default(0);
            $table->tinyInteger('dinner')->default(0);
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
        Schema::dropIfExists('house_detials');
    }
};

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
        Schema::table('house_terms', function (Blueprint $table) {
            $table->foreign(['housings_id'])->references(['id'])->on('housings')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('house_terms', function (Blueprint $table) {
            $table->dropForeign('house_terms_housings_id_foreign');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPerhiasanIdToDataSetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_set', function (Blueprint $table) {
            $table->integer('perhiasan_id')->nullable()->after('id');
            $table->foreign('perhiasan_id')->references('id')->on('perhiasan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_set', function (Blueprint $table) {
            $table->dropForeign(['perhiasan_id']);
            $table->dropColumn('perhiasan_id');
        });
    }
}

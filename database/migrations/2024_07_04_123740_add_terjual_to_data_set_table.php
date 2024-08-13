<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTerjualToDataSetTable extends Migration
{
    public function up()
    {
        Schema::table('data_set', function (Blueprint $table) {
            $table->integer('terjual')->after('stok')->default(0);
        });
    }

    public function down()
    {
        Schema::table('data_set', function (Blueprint $table) {
            $table->dropColumn('terjual');
        });
    }
}

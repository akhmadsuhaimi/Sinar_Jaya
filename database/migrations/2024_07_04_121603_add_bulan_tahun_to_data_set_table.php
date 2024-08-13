<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBulanTahunToDataSetTable extends Migration
{
    public function up()
    {
        Schema::table('data_set', function (Blueprint $table) {
            $table->string('bulan')->after('stok');
            $table->string('tahun')->after('bulan');
        });
    }

    public function down()
    {
        Schema::table('data_set', function (Blueprint $table) {
            $table->dropColumn(['bulan', 'tahun']);
        });
    }
}


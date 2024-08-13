<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatasetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datasets', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->string('kategori');
            $table->integer('karat');
            $table->float('gram');
            $table->decimal('harga', 15, 2);
            $table->integer('stok');
            $table->string('hasil'); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('datasets');
    }
}

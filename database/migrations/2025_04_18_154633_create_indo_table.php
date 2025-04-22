<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndoTable extends Migration
{
    public function up()
    {
        Schema::create('indo', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('namabarang');
            $table->decimal('harga', 10, 2); // Harga barang
            $table->integer('jumlahbarang')->default(0); // Stok barang
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('indo');
    }
}

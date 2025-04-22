<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // database/migrations/[timestamp]_create_pembelians_table.php
Schema::create('pembelians', function (Blueprint $table) {
    $table->id();
    $table->foreignId('indo_id')->constrained();
    $table->string('nama_pembeli');
    $table->text('alamat');
    $table->string('no_hp', 20);
    $table->integer('jumlah_beli');
    $table->decimal('harga_satuan', 10, 2);
    $table->decimal('total_harga', 10, 2);
    $table->string('metode_pembayaran');
    $table->string('status')->default('pending');
    $table->timestamps();
});
    }

    public function down()
    {
        Schema::dropIfExists('pembelians');
    }
};
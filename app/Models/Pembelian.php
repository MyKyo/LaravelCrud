<?php

// app/Models/Pembelian.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $fillable = [
        'indo_id',
        'nama_pembeli',
        'alamat',
        'no_hp',
        'jumlah_beli',
        'harga_satuan',
        'total_harga',
        'metode_pembayaran',
        'status'
    ];

    public function indo()
    {
        return $this->belongsTo(Indo::class);
    }
}
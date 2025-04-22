<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Indo extends Model
{
    protected $table = 'indo'; // Tentukan nama tabel secara eksplisit
    
    protected $fillable = ['nama', 'namabarang', 'harga', 'jumlahbarang'];

    public function pembelians()
    {
        return $this->hasMany(Pembelian::class);
    }
}
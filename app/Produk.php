<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'm_produk';
    protected $fillable = [
        'id',
        'nama_produk',
        'kategori_produk',
        'harga',
        'kuantitas',
        'created_at',
        'updated_at',
    ];
}

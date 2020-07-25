<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'm_customer';
    protected $fillable = [
        'id',
        'nama_customer',
        'no_telp',
        'alamat',
        'created_at',
        'updated_at',
    ];

}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_customer')->insert([
            'nama_customer' => 'Rafy Fakhrizal H',
            'alamat' => 'Kp. Curug Dog Dog RT 05/10 No.152',
            'no_telp' => '0895325143286',
        ]);
        DB::table('m_produk')->insert([
            'nama_produk' => 'Ayam',
            'kuantitas' => '20',
            'harga' => '25000',
            'kategori_produk' => 'hewan',
        ],['nama_produk' => 'Lemari',
        'kuantitas' => '10',
        'harga' => '550000',
        'kategori_produk' => 'meubeul',]);
    }
}

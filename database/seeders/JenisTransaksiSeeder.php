<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JenisTransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah data sudah ada
    if (DB::table('jenis_transaksis')->count() == 0) {
        $jenisTransaksis = [
            ['id_jenis_transaksi' => 1, 'nama_jenis_transaksi' => 'peminjaman'],
            ['id_jenis_transaksi' => 2, 'nama_jenis_transaksi' => 'isi ulang']
        ];
        DB::table('jenis_transaksis')->insert($jenisTransaksis);
    }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DetailTransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $detailTransaksis = [
            ['id_detail_transaksi' => 1, 'id_transaksi' => 1, 'id_tabung' => 1, 'id_jenis_transaksi' => 1, 'harga' => 150000, 'batas_waktu_peminjaman' => '2025-05-31', 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 2, 'id_transaksi' => 1, 'id_tabung' => 6, 'id_jenis_transaksi' => 1, 'harga' => 175000, 'batas_waktu_peminjaman' => '2025-05-31', 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 3, 'id_transaksi' => 2, 'id_tabung' => 11, 'id_jenis_transaksi' => 2, 'harga' => 200000, 'batas_waktu_peminjaman' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 4, 'id_transaksi' => 3, 'id_tabung' => 7, 'id_jenis_transaksi' => 2, 'harga' => 175000, 'batas_waktu_peminjaman' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 5, 'id_transaksi' => 4, 'id_tabung' => 2, 'id_jenis_transaksi' => 1, 'harga' => 150000, 'batas_waktu_peminjaman' => '2025-06-03', 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 6, 'id_transaksi' => 5, 'id_tabung' => 3, 'id_jenis_transaksi' => 1, 'harga' => 150000, 'batas_waktu_peminjaman' => '2025-06-04', 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 7, 'id_transaksi' => 6, 'id_tabung' => 5, 'id_jenis_transaksi' => 2, 'harga' => 150000, 'batas_waktu_peminjaman' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 8, 'id_transaksi' => 7, 'id_tabung' => 4, 'id_jenis_transaksi' => 1, 'harga' => 150000, 'batas_waktu_peminjaman' => '2025-06-06', 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 9, 'id_transaksi' => 7, 'id_tabung' => 16, 'id_jenis_transaksi' => 2, 'harga' => 225000, 'batas_waktu_peminjaman' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 10, 'id_transaksi' => 7, 'id_tabung' => 12, 'id_jenis_transaksi' => 2, 'harga' => 200000, 'batas_waktu_peminjaman' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 11, 'id_transaksi' => 8, 'id_tabung' => 17, 'id_jenis_transaksi' => 1, 'harga' => 225000, 'batas_waktu_peminjaman' => '2025-06-07', 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 12, 'id_transaksi' => 8, 'id_tabung' => 13, 'id_jenis_transaksi' => 2, 'harga' => 200000, 'batas_waktu_peminjaman' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 13, 'id_transaksi' => 9, 'id_tabung' => 18, 'id_jenis_transaksi' => 1, 'harga' => 225000, 'batas_waktu_peminjaman' => '2025-06-08', 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 14, 'id_transaksi' => 9, 'id_tabung' => 14, 'id_jenis_transaksi' => 2, 'harga' => 200000, 'batas_waktu_peminjaman' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 15, 'id_transaksi' => 10, 'id_tabung' => 19, 'id_jenis_transaksi' => 1, 'harga' => 150000, 'batas_waktu_peminjaman' => '2025-06-09', 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 16, 'id_transaksi' => 11, 'id_tabung' => 20, 'id_jenis_transaksi' => 2, 'harga' => 225000, 'batas_waktu_peminjaman' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 17, 'id_transaksi' => 11, 'id_tabung' => 8, 'id_jenis_transaksi' => 2, 'harga' => 175000, 'batas_waktu_peminjaman' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 18, 'id_transaksi' => 12, 'id_tabung' => 21, 'id_jenis_transaksi' => 1, 'harga' => 250000, 'batas_waktu_peminjaman' => '2025-06-11', 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 19, 'id_transaksi' => 12, 'id_tabung' => 22, 'id_jenis_transaksi' => 1, 'harga' => 250000, 'batas_waktu_peminjaman' => '2025-06-11', 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 20, 'id_transaksi' => 12, 'id_tabung' => 23, 'id_jenis_transaksi' => 1, 'harga' => 250000, 'batas_waktu_peminjaman' => '2025-06-11', 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 21, 'id_transaksi' => 12, 'id_tabung' => 24, 'id_jenis_transaksi' => 1, 'harga' => 250000, 'batas_waktu_peminjaman' => '2025-06-11', 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 22, 'id_transaksi' => 12, 'id_tabung' => 25, 'id_jenis_transaksi' => 1, 'harga' => 250000, 'batas_waktu_peminjaman' => '2025-06-11', 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 23, 'id_transaksi' => 13, 'id_tabung' => 9, 'id_jenis_transaksi' => 1, 'harga' => 175000, 'batas_waktu_peminjaman' => '2025-06-12', 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 24, 'id_transaksi' => 13, 'id_tabung' => 10, 'id_jenis_transaksi' => 2, 'harga' => 175000, 'batas_waktu_peminjaman' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 25, 'id_transaksi' => 14, 'id_tabung' => 15, 'id_jenis_transaksi' => 1, 'harga' => 200000, 'batas_waktu_peminjaman' => '2025-06-13', 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 26, 'id_transaksi' => 14, 'id_tabung' => 1, 'id_jenis_transaksi' => 1, 'harga' => 150000, 'batas_waktu_peminjaman' => '2025-06-13', 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 27, 'id_transaksi' => 14, 'id_tabung' => 6, 'id_jenis_transaksi' => 1, 'harga' => 175000, 'batas_waktu_peminjaman' => '2025-06-13', 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 28, 'id_transaksi' => 14, 'id_tabung' => 11, 'id_jenis_transaksi' => 1, 'harga' => 200000, 'batas_waktu_peminjaman' => '2025-06-13', 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 29, 'id_transaksi' => 14, 'id_tabung' => 16, 'id_jenis_transaksi' => 1, 'harga' => 225000, 'batas_waktu_peminjaman' => '2025-06-13', 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 30, 'id_transaksi' => 15, 'id_tabung' => 2, 'id_jenis_transaksi' => 2, 'harga' => 150000, 'batas_waktu_peminjaman' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 31, 'id_transaksi' => 16, 'id_tabung' => 26, 'id_jenis_transaksi' => 1, 'harga' => 150000, 'batas_waktu_peminjaman' => '2025-06-13', 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 32, 'id_transaksi' => 16, 'id_tabung' => 41, 'id_jenis_transaksi' => 1, 'harga' => 175000, 'batas_waktu_peminjaman' => '2025-06-14', 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 33, 'id_transaksi' => 17, 'id_tabung' => 103, 'id_jenis_transaksi' => 2, 'harga' => 200000, 'batas_waktu_peminjaman' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 34, 'id_transaksi' => 18, 'id_tabung' => 102, 'id_jenis_transaksi' => 2, 'harga' => 175000, 'batas_waktu_peminjaman' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 35, 'id_transaksi' => 19, 'id_tabung' => 42, 'id_jenis_transaksi' => 1, 'harga' => 150000, 'batas_waktu_peminjaman' => '2025-06-14', 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 36, 'id_transaksi' => 20, 'id_tabung' => 27, 'id_jenis_transaksi' => 1, 'harga' => 150000, 'batas_waktu_peminjaman' => '2025-06-13', 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 37, 'id_transaksi' => 21, 'id_tabung' => 101, 'id_jenis_transaksi' => 2, 'harga' => 150000, 'batas_waktu_peminjaman' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 38, 'id_transaksi' => 22, 'id_tabung' => 101, 'id_jenis_transaksi' => 2, 'harga' => 150000, 'batas_waktu_peminjaman' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 39, 'id_transaksi' => 22, 'id_tabung' => 56, 'id_jenis_transaksi' => 1, 'harga' => 200000, 'batas_waktu_peminjaman' => '2025-06-13', 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 40, 'id_transaksi' => 22, 'id_tabung' => 71, 'id_jenis_transaksi' => 1, 'harga' => 225000, 'batas_waktu_peminjaman' => '2025-06-13', 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 41, 'id_transaksi' => 23, 'id_tabung' => 56, 'id_jenis_transaksi' => 1, 'harga' => 200000, 'batas_waktu_peminjaman' => '2025-06-14', 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 42, 'id_transaksi' => 23, 'id_tabung' => 104, 'id_jenis_transaksi' => 2, 'harga' => 225000, 'batas_waktu_peminjaman' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 43, 'id_transaksi' => 24, 'id_tabung' => 57, 'id_jenis_transaksi' => 1, 'harga' => 200000, 'batas_waktu_peminjaman' => '2025-06-13', 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 44, 'id_transaksi' => 24, 'id_tabung' => 104, 'id_jenis_transaksi' => 2, 'harga' => 225000, 'batas_waktu_peminjaman' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 45, 'id_transaksi' => 25, 'id_tabung' => 28, 'id_jenis_transaksi' => 1, 'harga' => 150000, 'batas_waktu_peminjaman' => '2025-06-14', 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 46, 'id_transaksi' => 26, 'id_tabung' => 101, 'id_jenis_transaksi' => 2, 'harga' => 150000, 'batas_waktu_peminjaman' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 47, 'id_transaksi' => 26, 'id_tabung' => 102, 'id_jenis_transaksi' => 2, 'harga' => 175000, 'batas_waktu_peminjaman' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 48, 'id_transaksi' => 27, 'id_tabung' => 101, 'id_jenis_transaksi' => 2, 'harga' => 150000, 'batas_waktu_peminjaman' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 49, 'id_transaksi' => 27, 'id_tabung' => 102, 'id_jenis_transaksi' => 2, 'harga' => 175000, 'batas_waktu_peminjaman' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 50, 'id_transaksi' => 27, 'id_tabung' => 103, 'id_jenis_transaksi' => 2, 'harga' => 220000, 'batas_waktu_peminjaman' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 51, 'id_transaksi' => 27, 'id_tabung' => 72, 'id_jenis_transaksi' => 1, 'harga' => 225000, 'batas_waktu_peminjaman' => '2025-06-14', 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 52, 'id_transaksi' => 27, 'id_tabung' => 86, 'id_jenis_transaksi' => 1, 'harga' => 250000, 'batas_waktu_peminjaman' => '2025-06-14', 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 53, 'id_transaksi' => 28, 'id_tabung' => 101, 'id_jenis_transaksi' => 2, 'harga' => 150000, 'batas_waktu_peminjaman' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 54, 'id_transaksi' => 28, 'id_tabung' => 29, 'id_jenis_transaksi' => 1, 'harga' => 150000, 'batas_waktu_peminjaman' => '2025-06-13', 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 55, 'id_transaksi' => 29, 'id_tabung' => 30, 'id_jenis_transaksi' => 1, 'harga' => 150000, 'batas_waktu_peminjaman' => '2025-06-14', 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 56, 'id_transaksi' => 29, 'id_tabung' => 43, 'id_jenis_transaksi' => 1, 'harga' => 175000, 'batas_waktu_peminjaman' => '2025-06-14', 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 57, 'id_transaksi' => 29, 'id_tabung' => 103, 'id_jenis_transaksi' => 2, 'harga' => 220000, 'batas_waktu_peminjaman' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 58, 'id_transaksi' => 29, 'id_tabung' => 104, 'id_jenis_transaksi' => 2, 'harga' => 225000, 'batas_waktu_peminjaman' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 59, 'id_transaksi' => 29, 'id_tabung' => 105, 'id_jenis_transaksi' => 2, 'harga' => 250000, 'batas_waktu_peminjaman' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id_detail_transaksi' => 60, 'id_transaksi' => 30, 'id_tabung' => 102, 'id_jenis_transaksi' => 2, 'harga' => 175000, 'batas_waktu_peminjaman' => null, 'created_at' => now(), 'updated_at' => now()],
        ];

        // Hitung total_transaksi berdasarkan jumlah harga per id_transaksi
        $transaksiTotals = [];
        foreach ($detailTransaksis as $detail) {
            $transaksiId = $detail['id_transaksi'];
            if (!isset($transaksiTotals[$transaksiId])) {
                $transaksiTotals[$transaksiId] = 0;
            }
            $transaksiTotals[$transaksiId] += $detail['harga'];
        }

        // Update total_transaksi di detail_transaksis
        // foreach ($detailTransaksis as &$detail) {
        //     $transaksiId = $detail['id_transaksi'];
        //     $detail['total_transaksi'] = $transaksiTotals[$transaksiId];
        // }

        // Insert data ke tabel detail_transaksis
        DB::table('detail_transaksis')->insert($detailTransaksis);    
    }
}

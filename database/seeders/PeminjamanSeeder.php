<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PeminjamanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $peminjamans = [
            ['id_peminjaman' => 1, 'id_detail_transaksi' => 1, 'tanggal_pinjam' => '2023-01-01', 'status_pinjam' => 'selesai'],
            ['id_peminjaman' => 2, 'id_detail_transaksi' => 2, 'tanggal_pinjam' => '2023-01-01', 'status_pinjam' => 'selesai'],
            ['id_peminjaman' => 3, 'id_detail_transaksi' => 5, 'tanggal_pinjam' => '2023-01-04', 'status_pinjam' => 'selesai'],
            ['id_peminjaman' => 4, 'id_detail_transaksi' => 6, 'tanggal_pinjam' => '2023-01-05', 'status_pinjam' => 'selesai'],
            ['id_peminjaman' => 5, 'id_detail_transaksi' => 8, 'tanggal_pinjam' => '2023-01-07', 'status_pinjam' => 'selesai'],
            ['id_peminjaman' => 6, 'id_detail_transaksi' => 11, 'tanggal_pinjam' => '2023-01-08', 'status_pinjam' => 'selesai'],
            ['id_peminjaman' => 7, 'id_detail_transaksi' => 13, 'tanggal_pinjam' => '2023-01-09', 'status_pinjam' => 'selesai'],
            ['id_peminjaman' => 8, 'id_detail_transaksi' => 15, 'tanggal_pinjam' => '2023-01-10', 'status_pinjam' => 'aktif'],
            ['id_peminjaman' => 9, 'id_detail_transaksi' => 18, 'tanggal_pinjam' => '2023-01-12', 'status_pinjam' => 'aktif'],
            ['id_peminjaman' => 10, 'id_detail_transaksi' => 19, 'tanggal_pinjam' => '2023-01-12', 'status_pinjam' => 'aktif'],
            ['id_peminjaman' => 11, 'id_detail_transaksi' => 20, 'tanggal_pinjam' => '2023-01-12', 'status_pinjam' => 'aktif'],
            ['id_peminjaman' => 12, 'id_detail_transaksi' => 21, 'tanggal_pinjam' => '2023-01-12', 'status_pinjam' => 'aktif'],
            ['id_peminjaman' => 13, 'id_detail_transaksi' => 22, 'tanggal_pinjam' => '2023-01-12', 'status_pinjam' => 'aktif'],
            ['id_peminjaman' => 14, 'id_detail_transaksi' => 23, 'tanggal_pinjam' => '2023-01-13', 'status_pinjam' => 'aktif'],
            ['id_peminjaman' => 15, 'id_detail_transaksi' => 25, 'tanggal_pinjam' => '2023-01-14', 'status_pinjam' => 'aktif'],
            ['id_peminjaman' => 16, 'id_detail_transaksi' => 26, 'tanggal_pinjam' => '2023-01-14', 'status_pinjam' => 'aktif'],
            ['id_peminjaman' => 17, 'id_detail_transaksi' => 27, 'tanggal_pinjam' => '2023-01-14', 'status_pinjam' => 'aktif'],
            ['id_peminjaman' => 18, 'id_detail_transaksi' => 28, 'tanggal_pinjam' => '2023-01-14', 'status_pinjam' => 'aktif'],
            ['id_peminjaman' => 19, 'id_detail_transaksi' => 29, 'tanggal_pinjam' => '2023-01-14', 'status_pinjam' => 'aktif'],
            ['id_peminjaman' => 20, 'id_detail_transaksi' => 31, 'tanggal_pinjam' => '2024-01-15', 'status_pinjam' => 'aktif'],
            ['id_peminjaman' => 21, 'id_detail_transaksi' => 32, 'tanggal_pinjam' => '2024-01-15', 'status_pinjam' => 'aktif'],
            ['id_peminjaman' => 22, 'id_detail_transaksi' => 35, 'tanggal_pinjam' => '2024-01-15', 'status_pinjam' => 'aktif'],
            ['id_peminjaman' => 23, 'id_detail_transaksi' => 36, 'tanggal_pinjam' => '2024-01-15', 'status_pinjam' => 'selesai'],
            ['id_peminjaman' => 24, 'id_detail_transaksi' => 39, 'tanggal_pinjam' => '2025-01-15', 'status_pinjam' => 'selesai'],
            ['id_peminjaman' => 25, 'id_detail_transaksi' => 40, 'tanggal_pinjam' => '2026-01-15', 'status_pinjam' => 'selesai'],
            ['id_peminjaman' => 26, 'id_detail_transaksi' => 41, 'tanggal_pinjam' => '2026-01-15', 'status_pinjam' => 'aktif'],
            ['id_peminjaman' => 27, 'id_detail_transaksi' => 43, 'tanggal_pinjam' => '2026-01-15', 'status_pinjam' => 'aktif'],
            ['id_peminjaman' => 28, 'id_detail_transaksi' => 45, 'tanggal_pinjam' => '2026-01-15', 'status_pinjam' => 'aktif'],
            ['id_peminjaman' => 29, 'id_detail_transaksi' => 51, 'tanggal_pinjam' => '2026-01-15', 'status_pinjam' => 'selesai'],
            ['id_peminjaman' => 30, 'id_detail_transaksi' => 52, 'tanggal_pinjam' => '2026-01-15', 'status_pinjam' => 'selesai'],
            ['id_peminjaman' => 31, 'id_detail_transaksi' => 54, 'tanggal_pinjam' => '2026-01-15', 'status_pinjam' => 'aktif'],
            ['id_peminjaman' => 32, 'id_detail_transaksi' => 55, 'tanggal_pinjam' => '2026-01-15', 'status_pinjam' => 'selesai'],
            ['id_peminjaman' => 33, 'id_detail_transaksi' => 56, 'tanggal_pinjam' => '2026-01-15', 'status_pinjam' => 'selesai'],
        ];

        DB::table('peminjamans')->insert($peminjamans);
    }
}

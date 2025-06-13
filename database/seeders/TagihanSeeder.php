<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TagihanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tagihans = [
            ['id_tagihan' => 1, 'id_transaksi' => 2, 'jumlah_dibayar' => 0, 'sisa' => 200000, 'status' => 'belum_lunas', 'tanggal_bayar_tagihan' => null, 'hari_keterlambatan' => 0, 'periode_ke' => 0, 'keterangan' => 'Tagihan isi ulang argon - belum_dibayar'],
            ['id_tagihan' => 2, 'id_transaksi' => 3, 'jumlah_dibayar' => 0, 'sisa' => 175000, 'status' => 'belum_lunas', 'tanggal_bayar_tagihan' => null, 'hari_keterlambatan' => 5, 'periode_ke' => 1, 'keterangan' => 'Tagihan nitrogen - terlambat 5 hari'],
            ['id_tagihan' => 3, 'id_transaksi' => 10, 'jumlah_dibayar' => 50000, 'sisa' => 100000, 'status' => 'belum_lunas', 'tanggal_bayar_tagihan' => '2023-01-12', 'hari_keterlambatan' => 0, 'periode_ke' => 0, 'keterangan' => 'Pembayaran sebagian peminjaman oksigen'],
            ['id_tagihan' => 4, 'id_transaksi' => 12, 'jumlah_dibayar' => 500000, 'sisa' => 450000, 'status' => 'belum_lunas', 'tanggal_bayar_tagihan' => '2023-01-15', 'hari_keterlambatan' => 0, 'periode_ke' => 0, 'keterangan' => 'Pembayaran awal multiple tabung'],
            ['id_tagihan' => 5, 'id_transaksi' => 13, 'jumlah_dibayar' => 100000, 'sisa' => 225000, 'status' => 'belum_lunas', 'tanggal_bayar_tagihan' => '2023-01-16', 'hari_keterlambatan' => 0, 'periode_ke' => 0, 'keterangan' => 'Pembayaran sebagian nitrogen'],
            ['id_tagihan' => 6, 'id_transaksi' => 14, 'jumlah_dibayar' => 0, 'sisa' => 950000, 'status' => 'belum_lunas', 'tanggal_bayar_tagihan' => null, 'hari_keterlambatan' => 10, 'periode_ke' => 1, 'keterangan' => 'Tagihan multiple tabung - terlambat 10 hari'],
            ['id_tagihan' => 7, 'id_transaksi' => 15, 'jumlah_dibayar' => 0, 'sisa' => 175000, 'status' => 'belum_lunas', 'tanggal_bayar_tagihan' => null, 'hari_keterlambatan' => 7, 'periode_ke' => 1, 'keterangan' => 'Tagihan nitrogen - terlambat 7 hari'],
            ['id_tagihan' => 8, 'id_transaksi' => 16, 'jumlah_dibayar' => 0, 'sisa' => 175000, 'status' => 'belum_lunas', 'tanggal_bayar_tagihan' => null, 'hari_keterlambatan' => 4, 'periode_ke' => 1, 'keterangan' => 'Tagihan nitrogen isi ulang - telambat 4 hari'],
            ['id_tagihan' => 9, 'id_transaksi' => 19, 'jumlah_dibayar' => 0, 'sisa' => 150000, 'status' => 'belum_lunas', 'tanggal_bayar_tagihan' => null, 'hari_keterlambatan' => 0, 'periode_ke' => 0, 'keterangan' => 'Tagihan oksigen pinjam - belum_bayar'],
            ['id_tagihan' => 10, 'id_transaksi' => 20, 'jumlah_dibayar' => 150000, 'sisa' => 0, 'status' => 'lunas', 'tanggal_bayar_tagihan' => '2024-02-18', 'hari_keterlambatan' => 3, 'periode_ke' => 1, 'keterangan' => 'Tagihan oksigen pinjam + keterlambatan - sudah lunas'],
            ['id_tagihan' => 11, 'id_transaksi' => 23, 'jumlah_dibayar' => 0, 'sisa' => 225000, 'status' => 'belum_lunas', 'tanggal_bayar_tagihan' => null, 'hari_keterlambatan' => 0, 'periode_ke' => 0, 'keterangan' => 'Tagihan isi ulang argon dan acetelyn - belum_dibayar'],
            ['id_tagihan' => 12, 'id_transaksi' => 24, 'jumlah_dibayar' => 0, 'sisa' => 225000, 'status' => 'belum_lunas', 'tanggal_bayar_tagihan' => null, 'hari_keterlambatan' => 2, 'periode_ke' => 1, 'keterangan' => ''],
            ['id_tagihan' => 13, 'id_transaksi' => 25, 'jumlah_dibayar' => 50000, 'sisa' => 50000, 'status' => 'belum_lunas', 'tanggal_bayar_tagihan' => null, 'hari_keterlambatan' => 0, 'periode_ke' => 0, 'keterangan' => 'Bayar nyicil'],
            ['id_tagihan' => 14, 'id_transaksi' => 27, 'jumlah_dibayar' => 500000, 'sisa' => 0, 'status' => 'lunas', 'tanggal_bayar_tagihan' => '2024-02-20', 'hari_keterlambatan' => 5, 'periode_ke' => 1, 'keterangan' => 'Pelunasan tagihan - terlambat 5 hari'],
            ['id_tagihan' => 15, 'id_transaksi' => 28, 'jumlah_dibayar' => 0, 'sisa' => 300000, 'status' => 'belum_lunas', 'tanggal_bayar_tagihan' => null, 'hari_keterlambatan' => 15, 'periode_ke' => 1, 'keterangan' => ''],
            ['id_tagihan' => 16, 'id_transaksi' => 29, 'jumlah_dibayar' => 750000, 'sisa' => 0, 'status' => 'lunas', 'tanggal_bayar_tagihan' => '2004-02-25', 'hari_keterlambatan' => 10, 'periode_ke' => 1, 'keterangan' => 'Pelunasan tagihan + keterlambatan'],
            ['id_tagihan' => 17, 'id_transaksi' => 30, 'jumlah_dibayar' => 100000, 'sisa' => 75000, 'status' => 'belum_lunas', 'tanggal_bayar_tagihan' => '2004-02-17', 'hari_keterlambatan' => 2, 'periode_ke' => 1, 'keterangan' => 'Bayar nyicil terlambat'],
        ];

        DB::table('tagihans')->insert($tagihans);
    }
}

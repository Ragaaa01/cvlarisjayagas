<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PengembalianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pengembalians = [
            ['id_pengembalian' => 1, 'id_peminjaman' => 1, 'tanggal_kembali' => '2023-01-15', 'kondisi_tabung' => 'baik', 'keterangan' => 'Pengembalian tepat waktu'],
            ['id_pengembalian' => 2, 'id_peminjaman' => 2, 'tanggal_kembali' => '2023-01-16', 'kondisi_tabung' => 'baik', 'keterangan' => 'Pengembalian normal'],
            ['id_pengembalian' => 3, 'id_peminjaman' => 3, 'tanggal_kembali' => '2023-01-19', 'kondisi_tabung' => 'rusak', 'keterangan' => 'Tabung penyok'],
            ['id_pengembalian' => 4, 'id_peminjaman' => 4, 'tanggal_kembali' => '2023-01-20', 'kondisi_tabung' => 'baik', 'keterangan' => 'Pengembalian sesuai jadwal'],
            ['id_pengembalian' => 5, 'id_peminjaman' => 5, 'tanggal_kembali' => '2023-01-22', 'kondisi_tabung' => 'baik', 'keterangan' => 'Pengembalian dengan isi ulang'],
            ['id_pengembalian' => 6, 'id_peminjaman' => 6, 'tanggal_kembali' => '2023-01-23', 'kondisi_tabung' => 'baik', 'keterangan' => 'Pengembalian bersama tabung isi ulang'],
            ['id_pengembalian' => 7, 'id_peminjaman' => 7, 'tanggal_kembali' => '2023-01-25', 'kondisi_tabung' => 'rusak', 'keterangan' => 'Kebocoran pada valve'],
            ['id_pengembalian' => 8, 'id_peminjaman' => 23, 'tanggal_kembali' => '2024-02-18', 'kondisi_tabung' => 'baik', 'keterangan' => 'Pengembalian terlambat 3 hari'],
            ['id_pengembalian' => 9, 'id_peminjaman' => 24, 'tanggal_kembali' => '2024-01-30', 'kondisi_tabung' => 'baik', 'keterangan' => 'Pengembalian tepat waktu'],
            ['id_pengembalian' => 10, 'id_peminjaman' => 25, 'tanggal_kembali' => '2024-01-30', 'kondisi_tabung' => 'baik', 'keterangan' => 'Pengembalian tepat waktu'],
            ['id_pengembalian' => 11, 'id_peminjaman' => 29, 'tanggal_kembali' => '2024-02-20', 'kondisi_tabung' => 'baik', 'keterangan' => 'Pengembalian terlambat 5 hari'],
            ['id_pengembalian' => 12, 'id_peminjaman' => 30, 'tanggal_kembali' => '2024-02-20', 'kondisi_tabung' => 'baik', 'keterangan' => 'Pengembalian terlambat 5 hari'],
        ];

        DB::table('pengembalians')->insert($pengembalians);
    }
}

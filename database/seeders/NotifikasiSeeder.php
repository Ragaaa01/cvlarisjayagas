<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NotifikasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notifikasis = [
            ['id_notifikasi' => 1, 'id_tagihan' => 1, 'id_template' => 1, 'tanggal_terjadwal' => '2025-01-09', 'status_baca' => false, 'waktu_dikirim' => '2025-01-09 10:18:00'],
            ['id_notifikasi' => 2, 'id_tagihan' => 1, 'id_template' => 2, 'tanggal_terjadwal' => '2025-01-11', 'status_baca' => false, 'waktu_dikirim' => '2025-01-11 10:18:00'],
            ['id_notifikasi' => 3, 'id_tagihan' => 1, 'id_template' => 3, 'tanggal_terjadwal' => '2025-01-12', 'status_baca' => false, 'waktu_dikirim' => '2025-01-12 10:18:00'],
            ['id_notifikasi' => 4, 'id_tagihan' => 2, 'id_template' => 1, 'tanggal_terjadwal' => '2025-01-10', 'status_baca' => false, 'waktu_dikirim' => '2025-01-10 10:18:00'],
            ['id_notifikasi' => 5, 'id_tagihan' => 2, 'id_template' => 2, 'tanggal_terjadwal' => '2025-01-12', 'status_baca' => false, 'waktu_dikirim' => '2025-01-12 10:18:00'],
            ['id_notifikasi' => 6, 'id_tagihan' => 2, 'id_template' => 3, 'tanggal_terjadwal' => '2025-01-13', 'status_baca' => false, 'waktu_dikirim' => '2025-01-13 10:18:00'],
            ['id_notifikasi' => 7, 'id_tagihan' => 2, 'id_template' => 4, 'tanggal_terjadwal' => '2025-01-14', 'status_baca' => false, 'waktu_dikirim' => '2025-01-14 10:18:00'],
            ['id_notifikasi' => 8, 'id_tagihan' => 3, 'id_template' => 1, 'tanggal_terjadwal' => '2025-01-17', 'status_baca' => false, 'waktu_dikirim' => '2025-01-17 10:18:00'],
            ['id_notifikasi' => 9, 'id_tagihan' => 3, 'id_template' => 2, 'tanggal_terjadwal' => '2025-01-19', 'status_baca' => false, 'waktu_dikirim' => '2025-01-19 10:18:00'],
            ['id_notifikasi' => 10, 'id_tagihan' => 3, 'id_template' => 3, 'tanggal_terjadwal' => '2025-01-20', 'status_baca' => false, 'waktu_dikirim' => '2025-01-20 10:18:00'],
            ['id_notifikasi' => 11, 'id_tagihan' => 4, 'id_template' => 1, 'tanggal_terjadwal' => '2025-01-22', 'status_baca' => false, 'waktu_dikirim' => '2025-01-22 10:18:00'],
            ['id_notifikasi' => 12, 'id_tagihan' => 4, 'id_template' => 2, 'tanggal_terjadwal' => '2025-01-24', 'status_baca' => false, 'waktu_dikirim' => '2025-01-24 10:18:00'],
            ['id_notifikasi' => 13, 'id_tagihan' => 4, 'id_template' => 3, 'tanggal_terjadwal' => '2025-01-25', 'status_baca' => false, 'waktu_dikirim' => '2025-01-25 10:18:00'],
            ['id_notifikasi' => 14, 'id_tagihan' => 5, 'id_template' => 1, 'tanggal_terjadwal' => '2025-01-23', 'status_baca' => false, 'waktu_dikirim' => '2025-01-23 10:18:00'],
            ['id_notifikasi' => 15, 'id_tagihan' => 5, 'id_template' => 2, 'tanggal_terjadwal' => '2025-01-25', 'status_baca' => false, 'waktu_dikirim' => '2025-01-25 10:18:00'],
            ['id_notifikasi' => 16, 'id_tagihan' => 5, 'id_template' => 3, 'tanggal_terjadwal' => '2025-01-26', 'status_baca' => false, 'waktu_dikirim' => '2025-01-26 10:18:00'],
            ['id_notifikasi' => 17, 'id_tagihan' => 6, 'id_template' => 1, 'tanggal_terjadwal' => '2025-01-21', 'status_baca' => false, 'waktu_dikirim' => '2025-01-21 10:18:00'],
            ['id_notifikasi' => 18, 'id_tagihan' => 6, 'id_template' => 2, 'tanggal_terjadwal' => '2025-01-23', 'status_baca' => false, 'waktu_dikirim' => '2025-01-23 10:18:00'],
            ['id_notifikasi' => 19, 'id_tagihan' => 6, 'id_template' => 3, 'tanggal_terjadwal' => '2025-01-24', 'status_baca' => false, 'waktu_dikirim' => '2025-01-24 10:18:00'],
            ['id_notifikasi' => 20, 'id_tagihan' => 6, 'id_template' => 4, 'tanggal_terjadwal' => '2025-01-25', 'status_baca' => false, 'waktu_dikirim' => '2025-01-25 10:18:00'],
            ['id_notifikasi' => 21, 'id_tagihan' => 7, 'id_template' => 1, 'tanggal_terjadwal' => '2025-01-18', 'status_baca' => false, 'waktu_dikirim' => '2025-01-18 10:18:00'],
            ['id_notifikasi' => 22, 'id_tagihan' => 7, 'id_template' => 2, 'tanggal_terjadwal' => '2025-01-20', 'status_baca' => false, 'waktu_dikirim' => '2025-01-20 10:18:00'],
            ['id_notifikasi' => 23, 'id_tagihan' => 7, 'id_template' => 3, 'tanggal_terjadwal' => '2025-01-21', 'status_baca' => false, 'waktu_dikirim' => '2025-01-21 10:18:00'],
            ['id_notifikasi' => 24, 'id_tagihan' => 7, 'id_template' => 4, 'tanggal_terjadwal' => '2025-01-22', 'status_baca' => false, 'waktu_dikirim' => '2025-01-22 10:18:00'],
            ['id_notifikasi' => 25, 'id_tagihan' => 8, 'id_template' => 5, 'tanggal_terjadwal' => '2025-01-15', 'status_baca' => false, 'waktu_dikirim' => '2025-01-15 10:18:00'],
            ['id_notifikasi' => 26, 'id_tagihan' => 10, 'id_template' => 5, 'tanggal_terjadwal' => '2025-01-12', 'status_baca' => false, 'waktu_dikirim' => '2025-01-12 10:18:00'],
            ['id_notifikasi' => 27, 'id_tagihan' => 12, 'id_template' => 5, 'tanggal_terjadwal' => '2025-01-15', 'status_baca' => false, 'waktu_dikirim' => '2025-01-15 10:18:00'],
            ['id_notifikasi' => 28, 'id_tagihan' => 13, 'id_template' => 5, 'tanggal_terjadwal' => '2025-01-16', 'status_baca' => false, 'waktu_dikirim' => '2025-01-16 10:18:00'],
            ['id_notifikasi' => 29, 'id_tagihan' => 15, 'id_template' => 7, 'tanggal_terjadwal' => '2025-01-08', 'status_baca' => false, 'waktu_dikirim' => '2025-01-08 10:18:00'],
            ['id_notifikasi' => 30, 'id_tagihan' => 17, 'id_template' => 7, 'tanggal_terjadwal' => '2025-01-05', 'status_baca' => false, 'waktu_dikirim' => '2025-01-05 10:18:00'],
        ];

        DB::table('notifikasis')->insert($notifikasis);
    }
}

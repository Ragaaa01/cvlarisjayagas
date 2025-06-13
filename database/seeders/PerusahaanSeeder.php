<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PerusahaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('perusahaans')->insert([
            [
                'id_perusahaan' => 1,
                'nama_perusahaan' => 'CV Laris Jaya Gas',
                'alamat_perusahaan' => 'Gang 2 Utara Karangampel, Indramayu',
                'email_perusahaan' => 'larisjayagas@gasindustri.com',
            ],
            [
                'id_perusahaan' => 2,
                'nama_perusahaan' => 'Tabung Gas Mandiri',
                'alamat_perusahaan' => 'Jl. Teknologi No.45, Bandung',
                'email_perusahaan' => 'contact@tabungmandiri.com',
            ],
            [
                'id_perusahaan' => 3,
                'nama_perusahaan' => 'Berkah Gas Utama',
                'alamat_perusahaan' => 'Jl. Logistik No.12, Surabaya',
                'email_perusahaan' => 'admin@berkahgas.com',
            ],
            [
                'id_perusahaan' => 4,
                'nama_perusahaan' => 'Surya Gas Lestari',
                'alamat_perusahaan' => 'Jl. Perdagangan No.8, Medan',
                'email_perusahaan' => 'ceo@suryagasteel.com',
            ],
            [
                'id_perusahaan' => 5,
                'nama_perusahaan' => 'Prima Gas Nusantara',
                'alamat_perusahaan' => 'Jl. Niaga No.33, Semarang',
                'email_perusahaan' => 'info@primagas.id',
            ],
            [
                'id_perusahaan' => 6,
                'nama_perusahaan' => 'Mitra Gas Sejahtera',
                'alamat_perusahaan' => 'Jl. Bismo No.78, Yogyakarta',
                'email_perusahaan' => 'support@mitragas.co.id',
            ],
            [
                'id_perusahaan' => 7,
                'nama_perusahaan' => 'Karya Gas Makmur',
                'alamat_perusahaan' => 'Jl. Komplek No.156, Denpasar',
                'email_perusahaan' => 'admin@karyagas.com',
            ],
            [
                'id_perusahaan' => 8,
                'nama_perusahaan' => 'Indah Gas Sentosa',
                'alamat_perusahaan' => 'Jl. Perindustrian No.23, Palembang',
                'email_perusahaan' => 'contact@indahgas.net',
            ],
            [
                'id_perusahaan' => 9,
                'nama_perusahaan' => 'Tunggal Gas Perkasa',
                'alamat_perusahaan' => 'Jl. Strategis No.67, Makassar',
                'email_perusahaan' => 'info@tunggas.co.id',
            ],
            [
                'id_perusahaan' => 10,
                'nama_perusahaan' => 'Maju Gas Bersama',
                'alamat_perusahaan' => 'Jl. Jl. Champlaas No.89, Malang',
                'email_perusahaan' => 'cs@majugas.com',
            ],
            [
                'id_perusahaan' => 11,
                'nama_perusahaan' => 'Gas Teknik Nusantara',
                'alamat_perusahaan' => 'Jl. Engineering No.34, Bogor',
                'email_perusahaan' => 'sales@gasteknik.net',
            ],
            [
                'id_perusahaan' => 12,
                'nama_perusahaan' => 'Samudra Gas Indonesia',
                'alamat_perusahaan' => 'Jl. Industri No.11, Tangerang',
                'email_perusahaan' => 'info@samudragas.co.id',
            ],
            [
                'id_perusahaan' => 13,
                'nama_perusahaan' => 'Delta Gas Internasional',
                'alamat_perusahaan' => 'Jl. Omega No.90, Bekasi',
                'email_perusahaan' => 'contact@deltagas.com',
            ],
            [
                'id_perusahaan' => 14,
                'nama_perusahaan' => 'Gas Medika Utama',
                'alamat_perusahaan' => 'Jl. Kesehatan No.77, Depok',
                'email_perusahaan' => 'support@gasmedika.com',
            ],
            [
                'id_perusahaan' => 15,
                'nama_perusahaan' => 'Gas Kimia Nusantara',
                'alamat_perusahaan' => 'Jl. Science No.55, Cimahi',
                'email_perusahaan' => 'info@gaskimia.co.id',
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JenisTabungSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          DB::table('jenis_tabungs')->insert([
            [
                'id_jenis_tabungs' => 1,
                'kode_jenis' => 'O',
                'nama_jenis' => 'Oksigen',
                'harga' => 150000,
            ],
            [
                'id_jenis_tabungs' => 2,
                'kode_jenis' => 'N',
                'nama_jenis' => 'Nitrogen',
                'harga' => 175000,
            ],
            [
                'id_jenis_tabungs' => 3,
                'kode_jenis' => 'AR',
                'nama_jenis' => 'Argon',
                'harga' => 200000,
            ],
            [
                'id_jenis_tabungs' => 4,
                'kode_jenis' => 'ACE',
                'nama_jenis' => 'Aceteline',
                'harga' => 225000,
            ],
            [
                'id_jenis_tabungs' => 5,
                'kode_jenis' => 'N2O',
                'nama_jenis' => 'Dinitrogen Oksida',
                'harga' => 250000,
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TabungSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('tabungs')->insert([
            ['kode_tabung' => 'O01', 'id_jenis_tabung' => 1, 'id_status_tabung' => 1],
            ['kode_tabung' => 'O02', 'id_jenis_tabung' => 1, 'id_status_tabung' => 1],
            ['kode_tabung' => 'O03', 'id_jenis_tabung' => 1, 'id_status_tabung' => 2],
            ['kode_tabung' => 'O04', 'id_jenis_tabung' => 1, 'id_status_tabung' => 3],
            ['kode_tabung' => 'O05', 'id_jenis_tabung' => 1, 'id_status_tabung' => 1],
            ['kode_tabung' => 'O06', 'id_jenis_tabung' => 1, 'id_status_tabung' => 2],
            ['kode_tabung' => 'O07', 'id_jenis_tabung' => 1, 'id_status_tabung' => 2],
            ['kode_tabung' => 'O08', 'id_jenis_tabung' => 1, 'id_status_tabung' => 2],
            ['kode_tabung' => 'O09', 'id_jenis_tabung' => 1, 'id_status_tabung' => 2],
            ['kode_tabung' => 'O10', 'id_jenis_tabung' => 1, 'id_status_tabung' => 1],
            ['kode_tabung' => 'O011', 'id_jenis_tabung' => 1, 'id_status_tabung' => 1],
            ['kode_tabung' => 'O012', 'id_jenis_tabung' => 1, 'id_status_tabung' => 1],
            ['kode_tabung' => 'O013', 'id_jenis_tabung' => 1, 'id_status_tabung' => 1],
            ['kode_tabung' => 'O014', 'id_jenis_tabung' => 1, 'id_status_tabung' => 1],
            ['kode_tabung' => 'O015', 'id_jenis_tabung' => 1, 'id_status_tabung' => 1],
            ['kode_tabung' => 'O016', 'id_jenis_tabung' => 1, 'id_status_tabung' => 1],
            ['kode_tabung' => 'O017', 'id_jenis_tabung' => 1, 'id_status_tabung' => 1],
            ['kode_tabung' => 'O018', 'id_jenis_tabung' => 1, 'id_status_tabung' => 1],
            ['kode_tabung' => 'O019', 'id_jenis_tabung' => 1, 'id_status_tabung' => 1],
            ['kode_tabung' => 'O020', 'id_jenis_tabung' => 1, 'id_status_tabung' => 1],

            ['kode_tabung' => 'OSR01', 'id_jenis_tabung' => 1, 'id_status_tabung' => 1],

            ['kode_tabung' => 'N01', 'id_jenis_tabung' => 2, 'id_status_tabung' => 2],
            ['kode_tabung' => 'N02', 'id_jenis_tabung' => 2, 'id_status_tabung' => 1],
            ['kode_tabung' => 'N03', 'id_jenis_tabung' => 2, 'id_status_tabung' => 1],
            ['kode_tabung' => 'N04', 'id_jenis_tabung' => 2, 'id_status_tabung' => 4],
            [ 'kode_tabung' => 'N05', 'id_jenis_tabung' => 2, 'id_status_tabung' => 1],
            [ 'kode_tabung' => 'N06', 'id_jenis_tabung' => 2, 'id_status_tabung' => 2],
            ['kode_tabung' => 'N07', 'id_jenis_tabung' => 2, 'id_status_tabung' => 2],
            ['kode_tabung' => 'N08', 'id_jenis_tabung' => 2, 'id_status_tabung' => 1],
            ['kode_tabung' => 'N09', 'id_jenis_tabung' => 2, 'id_status_tabung' => 1],
            ['kode_tabung' => 'N010', 'id_jenis_tabung' => 2, 'id_status_tabung' => 1],
            [ 'kode_tabung' => 'N011', 'id_jenis_tabung' => 2, 'id_status_tabung' => 1],
            [ 'kode_tabung' => 'N012', 'id_jenis_tabung' => 2, 'id_status_tabung' => 1],
            ['kode_tabung' => 'N013', 'id_jenis_tabung' => 2, 'id_status_tabung' => 1],
            ['kode_tabung' => 'N014', 'id_jenis_tabung' => 2, 'id_status_tabung' => 1],
            ['kode_tabung' => 'N015', 'id_jenis_tabung' => 2, 'id_status_tabung' => 1],
            ['kode_tabung' => 'N016', 'id_jenis_tabung' => 2, 'id_status_tabung' => 4],
            [ 'kode_tabung' => 'N017', 'id_jenis_tabung' => 2, 'id_status_tabung' => 1],
            [ 'kode_tabung' => 'N018', 'id_jenis_tabung' => 2, 'id_status_tabung' => 1],
            ['kode_tabung' => 'N019', 'id_jenis_tabung' => 2, 'id_status_tabung' => 1],
            ['kode_tabung' => 'N020', 'id_jenis_tabung' => 2, 'id_status_tabung' => 1],

            ['kode_tabung' => 'NSR01', 'id_jenis_tabung' => 2, 'id_status_tabung' => 1],
           
            ['kode_tabung' => 'AR01', 'id_jenis_tabung' => 3, 'id_status_tabung' => 1],
            ['kode_tabung' => 'AR02', 'id_jenis_tabung' => 3, 'id_status_tabung' => 1],
            ['kode_tabung' => 'AR03', 'id_jenis_tabung' => 3, 'id_status_tabung' => 1],
            ['kode_tabung' => 'AR04', 'id_jenis_tabung' => 3, 'id_status_tabung' => 2],
            ['kode_tabung' => 'AR05', 'id_jenis_tabung' => 3, 'id_status_tabung' => 1],
            ['kode_tabung' => 'AR06', 'id_jenis_tabung' => 3, 'id_status_tabung' => 2],
            ['kode_tabung' => 'AR07', 'id_jenis_tabung' => 3, 'id_status_tabung' => 2],
            ['kode_tabung' => 'AR08', 'id_jenis_tabung' => 3, 'id_status_tabung' => 1],
            ['kode_tabung' => 'AR09', 'id_jenis_tabung' => 3, 'id_status_tabung' => 1],
            ['kode_tabung' => 'AR010', 'id_jenis_tabung' => 3, 'id_status_tabung' => 2],
            ['kode_tabung' => 'AR011', 'id_jenis_tabung' => 3, 'id_status_tabung' => 1],
            ['kode_tabung' => 'AR012', 'id_jenis_tabung' => 3, 'id_status_tabung' => 1],
            ['kode_tabung' => 'AR013', 'id_jenis_tabung' => 3, 'id_status_tabung' => 1],
            ['kode_tabung' => 'AR014', 'id_jenis_tabung' => 3, 'id_status_tabung' => 1],
            ['kode_tabung' => 'AR015', 'id_jenis_tabung' => 3, 'id_status_tabung' => 1],
            ['kode_tabung' => 'AR016', 'id_jenis_tabung' => 3, 'id_status_tabung' => 3],
            ['kode_tabung' => 'AR017', 'id_jenis_tabung' => 3, 'id_status_tabung' => 1],
            ['kode_tabung' => 'AR018', 'id_jenis_tabung' => 3, 'id_status_tabung' => 1],
            ['kode_tabung' => 'AR019', 'id_jenis_tabung' => 3, 'id_status_tabung' => 1],
            ['kode_tabung' => 'AR020', 'id_jenis_tabung' => 3, 'id_status_tabung' => 1],

            ['kode_tabung' => 'ARSR01', 'id_jenis_tabung' => 3, 'id_status_tabung' => 1],

            ['kode_tabung' => 'AC01', 'id_jenis_tabung' => 4, 'id_status_tabung' => 1],
            ['kode_tabung' => 'AC02', 'id_jenis_tabung' => 4, 'id_status_tabung' => 1],
            ['kode_tabung' => 'AC03', 'id_jenis_tabung' => 4, 'id_status_tabung' => 1],
            ['kode_tabung' => 'AC04', 'id_jenis_tabung' => 4, 'id_status_tabung' => 1],
            ['kode_tabung' => 'AC05', 'id_jenis_tabung' => 4, 'id_status_tabung' => 2],
            ['kode_tabung' => 'AC06', 'id_jenis_tabung' => 4, 'id_status_tabung' => 2],
            ['kode_tabung' => 'AC07', 'id_jenis_tabung' => 4, 'id_status_tabung' => 1],
            ['kode_tabung' => 'AC08', 'id_jenis_tabung' => 4, 'id_status_tabung' => 1],
            ['kode_tabung' => 'AC09', 'id_jenis_tabung' => 4, 'id_status_tabung' => 1],
            ['kode_tabung' => 'AC010', 'id_jenis_tabung' => 4, 'id_status_tabung' => 1],
            ['kode_tabung' => 'AC011', 'id_jenis_tabung' => 4, 'id_status_tabung' => 1],
            ['kode_tabung' => 'AC012', 'id_jenis_tabung' => 4, 'id_status_tabung' => 1],
            ['kode_tabung' => 'AC013', 'id_jenis_tabung' => 4, 'id_status_tabung' => 1],
            ['kode_tabung' => 'AC014', 'id_jenis_tabung' => 4, 'id_status_tabung' => 1],
            ['kode_tabung' => 'AC015', 'id_jenis_tabung' => 4, 'id_status_tabung' => 1],
            ['kode_tabung' => 'AC016', 'id_jenis_tabung' => 4, 'id_status_tabung' => 1],
            ['kode_tabung' => 'AC017', 'id_jenis_tabung' => 4, 'id_status_tabung' => 1],
            ['kode_tabung' => 'AC018', 'id_jenis_tabung' => 4, 'id_status_tabung' => 1],
            ['kode_tabung' => 'AC019', 'id_jenis_tabung' => 4, 'id_status_tabung' => 1],
            ['kode_tabung' => 'AC020', 'id_jenis_tabung' => 4, 'id_status_tabung' => 1],

            ['kode_tabung' => 'ACSR01', 'id_jenis_tabung' => 4, 'id_status_tabung' => 1],

            ['kode_tabung' => 'N2O01', 'id_jenis_tabung' => 5, 'id_status_tabung' => 1],
            ['kode_tabung' => 'N2O02', 'id_jenis_tabung' => 5, 'id_status_tabung' => 1],
            ['kode_tabung' => 'N2O03', 'id_jenis_tabung' => 5, 'id_status_tabung' => 1],
            ['kode_tabung' => 'N2O04', 'id_jenis_tabung' => 5, 'id_status_tabung' => 1],
            ['kode_tabung' => 'N2O05', 'id_jenis_tabung' => 5, 'id_status_tabung' => 3],
            ['kode_tabung' => 'N2O06', 'id_jenis_tabung' => 5, 'id_status_tabung' => 3],
            ['kode_tabung' => 'N2O07', 'id_jenis_tabung' => 5, 'id_status_tabung' => 1],
            ['kode_tabung' => 'N2O08', 'id_jenis_tabung' => 5, 'id_status_tabung' => 1],
            ['kode_tabung' => 'N2O09', 'id_jenis_tabung' => 5, 'id_status_tabung' => 1],
            ['kode_tabung' => 'N2O010', 'id_jenis_tabung' => 5, 'id_status_tabung' => 1],
            ['kode_tabung' => 'N2O011', 'id_jenis_tabung' => 5, 'id_status_tabung' => 1],
            ['kode_tabung' => 'N2O012', 'id_jenis_tabung' => 5, 'id_status_tabung' => 1],
            ['kode_tabung' => 'N2O013', 'id_jenis_tabung' => 5, 'id_status_tabung' => 1],
            ['kode_tabung' => 'N2O014', 'id_jenis_tabung' => 5, 'id_status_tabung' => 1],
            ['kode_tabung' => 'N2O015', 'id_jenis_tabung' => 5, 'id_status_tabung' => 1],
            ['kode_tabung' => 'N2O016', 'id_jenis_tabung' => 5, 'id_status_tabung' => 1],
            ['kode_tabung' => 'N2O017', 'id_jenis_tabung' => 5, 'id_status_tabung' => 1],
            ['kode_tabung' => 'N2O018', 'id_jenis_tabung' => 5, 'id_status_tabung' => 1],
            ['kode_tabung' => 'N2O019', 'id_jenis_tabung' => 5, 'id_status_tabung' => 1],
            ['kode_tabung' => 'N2O020', 'id_jenis_tabung' => 5, 'id_status_tabung' => 1],

            ['kode_tabung' => 'N2OSR01', 'id_jenis_tabung' => 5, 'id_status_tabung' => 1],
        ]);
    }
}

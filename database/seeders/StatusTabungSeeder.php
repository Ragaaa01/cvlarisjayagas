<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StatusTabungSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('status_tabungs')->insert([
            [
                'status_tabung' => 'tersedia',
            ],
            [
                'status_tabung' => 'dipinjam',
            ],
            [
                'status_tabung' => 'rusak',
            ],
            [
                'status_tabung' => 'hilang',
            ],
        ]);
    }
}

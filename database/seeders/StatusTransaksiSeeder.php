<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StatusTransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Cek apakah data sudah ada
    if (DB::table('status_transaksis')->count() == 0) {
        $statuses = [
            ['id_status_transaksi' => 1, 'status' => 'success'],
            ['id_status_transaksi' => 2, 'status' => 'pending'],
            ['id_status_transaksi' => 3, 'status' => 'failed']
        ];
        
        DB::table('status_transaksis')->insert($statuses);
    } else {
        $this->command->info('Data status_transaksis sudah ada, tidak perlu di-seed lagi.');
    }

    }
}

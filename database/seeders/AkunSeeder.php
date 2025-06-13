<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AkunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run()
    {
        // Pastikan ada id_perorangan dummy (contoh: 1 dan 2)
        // Jika belum ada data perorangan, kamu harus seed perorangans dulu.

        DB::table('akuns')->insert([
            [
                'id_perorangan' => null,
                'email' => 'ragatonabesly1@gmail.com',
                'password' => Hash::make('password'), // Ganti sesuai kebutuhan
                'role' => 'administrator',
                'status_aktif' => true,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_perorangan' => null,
                'email' => 'pelanggan@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'pelanggan',
                'status_aktif' => true,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

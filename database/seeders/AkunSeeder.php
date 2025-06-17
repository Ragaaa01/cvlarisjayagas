<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class AkunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // Menggunakan locale Indonesia untuk data yang lebih realistis

        $akuns = [
            [
                'id_akun' => 1,
                'id_perorangan' => 1,
                'email' => 'administrator@larisjayagas.com',
                'password' => Hash::make('administrator123'),
                'role' => 'administrator',
                'status_aktif' => true,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_akun' => 2,
                'id_perorangan' => 31,
                'email' => 'pelanggan1@larisjayagas.com',
                'password' => Hash::make('pelanggan123'),
                'role' => 'pelanggan',
                'status_aktif' => true,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_akun' => 3,
                'id_perorangan' => 2,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password123'),
                'role' => 'pelanggan',
                'status_aktif' => true,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_akun' => 4,
                'id_perorangan' => 3,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password123'),
                'role' => 'pelanggan',
                'status_aktif' => true,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_akun' => 5,
                'id_perorangan' => 4,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password123'),
                'role' => 'pelanggan',
                'status_aktif' => true,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_akun' => 6,
                'id_perorangan' => 5,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password123'),
                'role' => 'pelanggan',
                'status_aktif' => false, // Contoh akun tidak aktif
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_akun' => 7,
                'id_perorangan' => 6,
                'email' => 'staf1@larisjayagas.com',
                'password' => Hash::make('password123'),
                'role' => 'pelanggan',
                'status_aktif' => true,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_akun' => 8,
                'id_perorangan' => 7,
                'email' => 'staf2@larisjayagas.com',
                'password' => Hash::make('password123'),
                'role' => 'pelanggan',
                'status_aktif' => true,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_akun' => 9,
                'id_perorangan' => 8,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password123'),
                'role' => 'pelanggan',
                'status_aktif' => true,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_akun' => 10,
                'id_perorangan' => 9,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password123'),
                'role' => 'pelanggan',
                'status_aktif' => true,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_akun' => 11,
                'id_perorangan' => 10,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password123'),
                'role' => 'pelanggan',
                'status_aktif' => true,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_akun' => 12,
                'id_perorangan' => 11,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password123'),
                'role' => 'pelanggan',
                'status_aktif' => true,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_akun' => 13,
                'id_perorangan' => 12,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password123'),
                'role' => 'pelanggan',
                'status_aktif' => true,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_ ascended_at' => 14,
                'id_perorangan' => 13,
                'email' => '$faker->unique()->safeEmail',
                'password' => Hash::make('password123'),
                'role' => 'pelanggan',
                'status_aktif' => true,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_akun' => 15,
                'id_perorangan' => 14,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password123'),
                'role' => 'pelanggan',
                'status_aktif' => true,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('akuns')->insert($akuns);
    }
}
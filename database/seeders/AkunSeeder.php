<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AkunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('akuns')->insert([
            [
                'id_akun' => 1,
                'id_perorangan' => 1,
                'email' => 'administrator@larisjayagas.com',
                'password' => bcrypt('administrator123'),
                'role' => 'administrator',
                'status_aktif' => true,
            ],
            [
                'id_akun' => 2,
                'id_perorangan' => 31,
                'email' => 'pelanggan@larisjayagas.com',
                'password' => bcrypt('pelanggan123'),
                'role' => 'pelanggan',
                'status_aktif' => true,
            ],
            [
                'id_akun' => 3,
                'id_perorangan' => 2,
                'email' => 'sitirahayu@gmail.com',
                'password' => bcrypt('pelanggan123'),
                'role' => 'pelanggan',
                'status_aktif' => true,
            ],
            [
                'id_akun' => 4,
                'id_perorangan' => 3,
                'email' => 'aguswijaya@email.com',
                'password' => bcrypt('pelanggan123'),
                'role' => 'pelanggan',
                'status_aktif' => true,
            ],
            [
                'id_akun' => 5,
                'id_perorangan' => 4,
                'email' => 'dewisetiarani@gmail.com',
                'password' => bcrypt('pelanggan123'),
                'role' => 'pelanggan',
                'status_aktif' => true,
            ],
            [
                'id_akun' => 6,
                'id_perorangan' => 5,
                'email' => 'hendrapratama@gmail.com',
                'password' => bcrypt('pelanggan123'),
                'role' => 'pelanggan',
                'status_aktif' => true,
            ],
            [
                'id_akun' => 7,
                'id_perorangan' => 6,
                'email' => 'lismanarina@gmail.com',
                'password' => bcrypt('pelanggan123'),
                'role' => 'pelanggan',
                'status_aktif' => true,
            ],
            [
                'id_akun' => 8,
                'id_perorangan' => 7,
                'email' => 'rudhiermawan@gmail.com',
                'password' => bcrypt('pelanggan123'),
                'role' => 'pelanggan',
                'status_aktif' => true,
            ],
            [
                'id_akun' => 9,
                'id_perorangan' => 8,
                'email' => 'agus@pelanggan.com',
                'password' => bcrypt('pelanggan123'),
                'role' => 'pelanggan',
                'status_aktif' => true,
            ],
            [
                'id_akun' => 10,
                'id_perorangan' => 9,
                'email' => 'ekoprastya@email.com',
                'password' => bcrypt('pelanggan123'),
                'role' => 'pelanggan',
                'status_aktif' => true,
            ],
            [
                'id_akun' => 11,
                'id_perorangan' => 10,
                'email' => 'mayohdanie@gmail.com',
                'password' => bcrypt('pelanggan123'),
                'role' => 'pelanggan',
                'status_aktif' => true,
            ],
            [
                'id_akun' => 12,
                'id_perorangan' => 11,
                'email' => 'adinuqroho@gmail.com',
                'password' => bcrypt('pelanggan123'),
                'role' => 'pelanggan',
                'status_aktif' => true,
            ],
            [
                'id_akun' => 13,
                'id_perorangan' => 12,
                'email' => 'rinawijayanti@gmail.com',
                'password' => bcrypt('pelanggan123'),
                'role' => 'pelanggan',
                'status_aktif' => true,
            ],
            [
                'id_akun' => 14,
                'id_perorangan' => 13,
                'email' => 'fajresetiawan@gmail.com',
                'password' => bcrypt('pelanggan123'),
                'role' => 'pelanggan',
                'status_aktif' => true,
            ],
            [
                'id_akun' => 15,
                'id_perorangan' => 14,
                'email' => 'dianpermata@gmail.com',
                'password' => bcrypt('pelanggan123'),
                'role' => 'pelanggan',
                'status_aktif' => true,
            ],
            [
                'id_akun' => 16,
                'id_perorangan' => 15,
                'email' => 'irfanmaulana@gmail.com',
                'password' => bcrypt('pelanggan123'),
                'role' => 'pelanggan',
                'status_aktif' => true,
            ]
        ]);
    }
}

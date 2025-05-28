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
                'id_akuns' => 1,
                'id_perorangan' => null,
                'email' => 'admin@gastrack.com',
                'password' => '$2a$10$skJw5W27rQ1t7QZVQnB.e9v',
                'role' => 'administrator',
                'status_aktif' => true,
            ],
            [
                'id_akuns' => 2,
                'id_perorangan' => 1,
                'email' => 'budisantoso@gmail.com',
                'password' => '$2a$10$H9bW9U8RtO6sW4E7t23YC.7vE',
                'role' => 'pelanggan',
                'status_aktif' => true,
            ],
            [
                'id_akuns' => 3,
                'id_perorangan' => 2,
                'email' => 'sitirahayu@gmail.com',
                'password' => '$2a$10$A8s7vRQs4eTT2U1Ie.G5Vk',
                'role' => 'pelanggan',
                'status_aktif' => true,
            ],
            [
                'id_akuns' => 4,
                'id_perorangan' => 3,
                'email' => 'aguswijaya@email.com',
                'password' => '$2a$10$H9bW9U8RtO6sW4E7t23YC.7vE',
                'role' => 'pelanggan',
                'status_aktif' => true,
            ],
            [
                'id_akuns' => 5,
                'id_perorangan' => 4,
                'email' => 'dewisetiarani@gmail.com',
                'password' => '$2a$10$H9bW9U8RtO6sW4E7t23YC.7vE',
                'role' => 'pelanggan',
                'status_aktif' => true,
            ],
            [
                'id_akuns' => 6,
                'id_perorangan' => 5,
                'email' => 'hendrapratama@gmail.com',
                'password' => '$2a$10$H9bW9U8RtO6sW4E7t23YC.7vE',
                'role' => 'pelanggan',
                'status_aktif' => true,
            ],
            [
                'id_akuns' => 7,
                'id_perorangan' => 6,
                'email' => 'lismanarina@gmail.com',
                'password' => '$2a$10$H9bW9U8RtO6sW4E7t23YC.7vE',
                'role' => 'pelanggan',
                'status_aktif' => true,
            ],
            [
                'id_akuns' => 8,
                'id_perorangan' => 7,
                'email' => 'rudhiermawan@gmail.com',
                'password' => '$2a$10$H9bW9U8RtO6sW4E7t23YC.7vE',
                'role' => 'pelanggan',
                'status_aktif' => true,
            ],
            [
                'id_akuns' => 9,
                'id_perorangan' => 8,
                'email' => 'agus@pelanggan.com',
                'password' => '$2a$10$H9bW9U8RtO6sW4E7t23YC.7vE',
                'role' => 'pelanggan',
                'status_aktif' => true,
            ],
            [
                'id_akuns' => 10,
                'id_perorangan' => 9,
                'email' => 'ekoprastya@email.com',
                'password' => '$2a$10$H9bW9U8RtO6sW4E7t23YC.7vE',
                'role' => 'pelanggan',
                'status_aktif' => true,
            ],
            [
                'id_akuns' => 11,
                'id_perorangan' => 10,
                'email' => 'mayohdanie@gmail.com',
                'password' => '$2a$10$H9bW9U8RtO6sW4E7t23YC.7vE',
                'role' => 'pelanggan',
                'status_aktif' => true,
            ],
            [
                'id_akuns' => 12,
                'id_perorangan' => 11,
                'email' => 'adinuqroho@gmail.com',
                'password' => '$2a$10$H9bW9U8RtO6sW4E7t23YC.7vE',
                'role' => 'pelanggan',
                'status_aktif' => true,
            ],
            [
                'id_akuns' => 13,
                'id_perorangan' => 12,
                'email' => 'rinawijayanti@gmail.com',
                'password' => '$2a$10$H9bW9U8RtO6sW4E7t23YC.7vE',
                'role' => 'pelanggan',
                'status_aktif' => true,
            ],
            [
                'id_akuns' => 14,
                'id_perorangan' => 13,
                'email' => 'fajresetiawan@gmail.com',
                'password' => '$2a$10$H9bW9U8RtO6sW4E7t23YC.7vE',
                'role' => 'pelanggan',
                'status_aktif' => true,
            ],
            [
                'id_akuns' => 15,
                'id_perorangan' => 14,
                'email' => 'dianpermata@gmail.com',
                'password' => '$2a$10$H9bW9U8RtO6sW4E7t23YC.7vE',
                'role' => 'pelanggan',
                'status_aktif' => true,
            ],
            [
                'id_akuns' => 16,
                'id_perorangan' => 15,
                'email' => 'irfanmaulana@gmail.com',
                'password' => '$2a$10$H9bW9U8RtO6sW4E7t23YC.7vE',
                'role' => 'pelanggan',
                'status_aktif' => true,
            ]
        ]);
    }
}

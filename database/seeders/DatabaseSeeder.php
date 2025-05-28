<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PerusahaanSeeder::class,
            PeroranganSeeder::class,
            AkunSeeder::class,
            JenisTabungSeeder::class,
            StatusTabungSeeder::class,
            TabungSeeder::class,
            StatusTransaksiSeeder::class,
            JenisTransaksiSeeder::class,
            TransaksiSeeder::class,
            DetailTransaksiSeeder::class,
            PeminjamanSeeder::class,
            PengembalianSeeder::class,
            TagihanSeeder::class,
            NotifikasiTemplateSeeder::class,
            NotifikasiSeeder::class,
            RiwayatTransaksiSeeder::class,
        ]);
    }
}

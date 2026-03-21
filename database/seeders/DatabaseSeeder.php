<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SekolahInfoSeeder::class,
            GuruSeeder::class,
            MataPelajaranSeeder::class,
            SiswaSeeder::class,
            NilaiSeeder::class,
            KegiatanSeeder::class,
            KriteriaSeeder::class,
            SekolahRekomendasiSeeder::class,
        ]);
    }
}
<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use Illuminate\Database\Seeder;

class KriteriaSeeder extends Seeder
{
    /**
     * Default SAW criteria for SMP selection.
     * Bobot total = 0.25 + 0.30 + 0.25 + 0.20 = 1.00
     */
    public function run(): void
    {
        $kriteria = [
            [
                'kode'   => 'C1',
                'nama'   => 'Biaya SPP',
                'jenis'  => 'cost',    // lower is better
                'bobot'  => 0.25,
                'urutan' => 1,
                'desc'   => 'Biaya SPP bulanan sekolah (Rupiah). Semakin rendah semakin baik.',
            ],
            [
                'kode'   => 'C2',
                'nama'   => 'Akreditasi',
                'jenis'  => 'benefit', // higher is better
                'bobot'  => 0.30,
                'urutan' => 2,
                'desc'   => 'Nilai akreditasi sekolah. A=100, B=80, C=60, Belum=40.',
            ],
            [
                'kode'   => 'C3',
                'nama'   => 'Fasilitas',
                'jenis'  => 'benefit',
                'bobot'  => 0.25,
                'urutan' => 3,
                'desc'   => 'Skor kelengkapan fasilitas sekolah (0–100).',
            ],
            [
                'kode'   => 'C4',
                'nama'   => 'Jarak / Lokasi',
                'jenis'  => 'cost',    // lower is better
                'bobot'  => 0.20,
                'urutan' => 4,
                'desc'   => 'Estimasi jarak dari pusat kota Batam (km). Semakin dekat semakin baik.',
            ],
        ];

        foreach ($kriteria as $k) {
            Kriteria::updateOrCreate(['kode_kriteria' => $k['kode']], [
                'nama_kriteria' => $k['nama'],
                'kode_kriteria' => $k['kode'],
                'jenis'         => $k['jenis'],
                'bobot'         => $k['bobot'],
                'deskripsi'     => $k['desc'],
                'is_active'     => true,
                'urutan'        => $k['urutan'],
            ]);
        }
    }
}
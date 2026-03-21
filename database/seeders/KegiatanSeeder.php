<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Kegiatan;
use App\Models\Siswa;
use Illuminate\Database\Seeder;

class KegiatanSeeder extends Seeder
{
    public function run(): void
    {
        $siswaList = Siswa::all();
        $guru      = Guru::first();

        if ($siswaList->isEmpty()) return;

        $kegiatanData = [
            // Akademik
            ['nama' => 'Olimpiade Matematika Tingkat Kota',    'jenis' => 'Akademik',       'prestasi' => 'Juara 2',    'tingkat' => 'Kota',      'tgl' => '2024-10-12'],
            ['nama' => 'Lomba Pidato Bahasa Indonesia',        'jenis' => 'Akademik',       'prestasi' => 'Juara 1',    'tingkat' => 'Kecamatan', 'tgl' => '2024-09-20'],
            ['nama' => 'Cerdas Cermat IPA',                    'jenis' => 'Akademik',       'prestasi' => 'Peserta',    'tingkat' => 'Sekolah',   'tgl' => '2024-11-05'],
            ['nama' => 'Lomba Menulis Cerpen',                 'jenis' => 'Akademik',       'prestasi' => 'Juara 3',    'tingkat' => 'Kota',      'tgl' => '2024-08-15'],
            // Keagamaan
            ['nama' => 'Musabaqah Tilawatil Quran (MTQ)',      'jenis' => 'Keagamaan',      'prestasi' => 'Juara 1',    'tingkat' => 'Kota',      'tgl' => '2024-10-01'],
            ['nama' => 'Hafalan Juz Amma',                     'jenis' => 'Keagamaan',      'prestasi' => 'Lulus',      'tingkat' => 'Sekolah',   'tgl' => '2024-07-20'],
            ['nama' => 'Lomba Adzan Tingkat Sekolah',          'jenis' => 'Keagamaan',      'prestasi' => 'Juara 2',    'tingkat' => 'Sekolah',   'tgl' => '2024-09-10'],
            ['nama' => 'Pekan Kaligrafi Islam',                'jenis' => 'Keagamaan',      'prestasi' => 'Juara 1',    'tingkat' => 'Kecamatan', 'tgl' => '2024-11-18'],
            // Ekstrakurikuler
            ['nama' => 'Turnamen Futsal Antar Sekolah',        'jenis' => 'Ekstrakurikuler','prestasi' => 'Juara 3',    'tingkat' => 'Kota',      'tgl' => '2024-08-25'],
            ['nama' => 'Pramuka Tingkat Penggalang',           'jenis' => 'Ekstrakurikuler','prestasi' => 'Peserta',    'tingkat' => 'Kota',      'tgl' => '2024-09-05'],
            ['nama' => 'Pertunjukan Seni Tari Daerah',         'jenis' => 'Ekstrakurikuler','prestasi' => 'Penampil',   'tingkat' => 'Sekolah',   'tgl' => '2024-12-01'],
            ['nama' => 'Lomba Bulu Tangkis Pelajar',           'jenis' => 'Ekstrakurikuler','prestasi' => 'Juara 2',    'tingkat' => 'Kecamatan', 'tgl' => '2024-10-22'],
            // Sosial
            ['nama' => 'Bakti Sosial ke Panti Asuhan',         'jenis' => 'Sosial',         'prestasi' => 'Peserta',    'tingkat' => 'Sekolah',   'tgl' => '2024-11-10'],
            ['nama' => 'Penanaman Pohon Mangrove',             'jenis' => 'Sosial',         'prestasi' => 'Peserta',    'tingkat' => 'Kota',      'tgl' => '2024-06-05'],
            // Tahfidz
            ['nama' => 'Tasmi\' Quran 1 Juz',                 'jenis' => 'Tahfidz',        'prestasi' => 'Lulus',      'tingkat' => 'Sekolah',   'tgl' => '2024-07-15'],
            ['nama' => 'Setoran Hafalan Juz 30',               'jenis' => 'Tahfidz',        'prestasi' => 'Lulus',      'tingkat' => 'Sekolah',   'tgl' => '2024-12-10'],
        ];

        // Distribute kegiatan across first 10 siswa
        $siswaSlice = $siswaList->take(10)->values();

        foreach ($kegiatanData as $i => $k) {
            // Assign each kegiatan to a different siswa (cycling)
            $siswa = $siswaSlice[$i % $siswaSlice->count()];

            Kegiatan::updateOrCreate(
                [
                    'siswa_id'      => $siswa->id,
                    'nama_kegiatan' => $k['nama'],
                ],
                [
                    'guru_id'          => $guru?->id,
                    'jenis_kegiatan'   => $k['jenis'],
                    'tanggal_kegiatan' => $k['tgl'],
                    'prestasi'         => $k['prestasi'],
                    'tingkat'          => $k['tingkat'],
                    'deskripsi'        => 'Kegiatan ' . $k['jenis'] . ' yang diikuti oleh siswa.',
                ]
            );
        }
    }
}
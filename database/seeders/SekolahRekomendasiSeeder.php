<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use App\Models\NilaiKriteria;
use App\Models\SekolahRekomendasi;
use Illuminate\Database\Seeder;

class SekolahRekomendasiSeeder extends Seeder
{
    /**
     * Criteria mapping (must match KriteriaSeeder):
     *   C1 = Biaya SPP   (cost)    — in Rupiah
     *   C2 = Akreditasi  (benefit) — A=100, B=80, C=60, Belum=40
     *   C3 = Fasilitas   (benefit) — score 0-100
     *   C4 = Jarak       (cost)    — km from Batam city center
     */
    public function run(): void
    {
        $schools = [
            [
                'nama'       => 'SMP Negeri 1 Batam',
                'npsn'       => '10100101',
                'jenis'      => 'Negeri',
                'akreditasi' => 'A',
                'alamat'     => 'Jl. Brigjen Katamso No. 1, Lubuk Baja, Batam Kota',
                'kecamatan'  => 'Lubuk Baja',
                'biaya_spp'  => 0,
                'fasilitas'  => ['Perpustakaan','Lab IPA','Lab Komputer','Lapangan','Masjid','Kantin'],
                'desc'       => 'SMP Negeri terbaik di Batam dengan fasilitas lengkap dan prestasi tinggi.',
                'jml_siswa'  => 900,
                'jml_guru'   => 55,
                // SAW scores: C1=biaya(0), C2=akreditasi(100), C3=fasilitas(90), C4=jarak(2)
                'saw' => ['C1' => 0, 'C2' => 100, 'C3' => 90, 'C4' => 2],
            ],
            [
                'nama'       => 'SMP Negeri 3 Batam',
                'npsn'       => '10100103',
                'jenis'      => 'Negeri',
                'akreditasi' => 'A',
                'alamat'     => 'Jl. Gajah Mada, Sagulung, Batam',
                'kecamatan'  => 'Sagulung',
                'biaya_spp'  => 0,
                'fasilitas'  => ['Perpustakaan','Lab IPA','Lapangan','Kantin','UKS'],
                'desc'       => 'Sekolah negeri unggulan di kawasan Sagulung dengan lingkungan belajar kondusif.',
                'jml_siswa'  => 750,
                'jml_guru'   => 42,
                'saw' => ['C1' => 0, 'C2' => 100, 'C3' => 80, 'C4' => 8],
            ],
            [
                'nama'       => 'SMP Islam Terpadu Al-Azhar',
                'npsn'       => '10100201',
                'jenis'      => 'Swasta',
                'akreditasi' => 'A',
                'alamat'     => 'Jl. R. Patah, Batam Kota',
                'kecamatan'  => 'Batam Kota',
                'biaya_spp'  => 800000,
                'fasilitas'  => ['Masjid','Perpustakaan','Lab Komputer','Lapangan','Tahfidz Room','Kantin Halal','UKS'],
                'desc'       => 'Sekolah Islam terpadu dengan program tahfidz dan kurikulum internasional.',
                'jml_siswa'  => 500,
                'jml_guru'   => 38,
                'saw' => ['C1' => 800000, 'C2' => 100, 'C3' => 88, 'C4' => 3],
            ],
            [
                'nama'       => 'SMP Hang Nadim Batam',
                'npsn'       => '10100301',
                'jenis'      => 'Swasta',
                'akreditasi' => 'B',
                'alamat'     => 'Jl. Engku Putri, Batam Centre',
                'kecamatan'  => 'Batam Kota',
                'biaya_spp'  => 500000,
                'fasilitas'  => ['Perpustakaan','Lab Komputer','Lapangan','Kantin'],
                'desc'       => 'Sekolah swasta dengan biaya terjangkau dan lokasi strategis di Batam Centre.',
                'jml_siswa'  => 320,
                'jml_guru'   => 25,
                'saw' => ['C1' => 500000, 'C2' => 80, 'C3' => 65, 'C4' => 4],
            ],
            [
                'nama'       => 'SMP Muhammadiyah 1 Batam',
                'npsn'       => '10100401',
                'jenis'      => 'Swasta',
                'akreditasi' => 'A',
                'alamat'     => 'Jl. Imam Bonjol, Batu Ampar',
                'kecamatan'  => 'Batu Ampar',
                'biaya_spp'  => 350000,
                'fasilitas'  => ['Masjid','Perpustakaan','Lab IPA','Lapangan','Kantin'],
                'desc'       => 'Sekolah Muhammadiyah dengan pendidikan agama Islam yang kuat dan biaya terjangkau.',
                'jml_siswa'  => 420,
                'jml_guru'   => 30,
                'saw' => ['C1' => 350000, 'C2' => 100, 'C3' => 72, 'C4' => 5],
            ],
            [
                'nama'       => 'SMP Santa Maria Batam',
                'npsn'       => '10100501',
                'jenis'      => 'Swasta',
                'akreditasi' => 'A',
                'alamat'     => 'Jl. Laksamana Bintan, Lubuk Baja',
                'kecamatan'  => 'Lubuk Baja',
                'biaya_spp'  => 950000,
                'fasilitas'  => ['Lab IPA','Lab Komputer','Perpustakaan','Lapangan','Kantin','Aula'],
                'desc'       => 'Sekolah swasta dengan standar tinggi, fasilitas modern, dan prestasi akademik.',
                'jml_siswa'  => 480,
                'jml_guru'   => 35,
                'saw' => ['C1' => 950000, 'C2' => 100, 'C3' => 92, 'C4' => 3],
            ],
            [
                'nama'       => 'SMP Negeri 6 Batam',
                'npsn'       => '10100106',
                'jenis'      => 'Negeri',
                'akreditasi' => 'B',
                'alamat'     => 'Jl. Seraya, Batu Ampar',
                'kecamatan'  => 'Batu Ampar',
                'biaya_spp'  => 0,
                'fasilitas'  => ['Perpustakaan','Lapangan','Kantin','UKS'],
                'desc'       => 'Sekolah negeri di kawasan Batu Ampar dengan akses transportasi mudah.',
                'jml_siswa'  => 600,
                'jml_guru'   => 35,
                'saw' => ['C1' => 0, 'C2' => 80, 'C3' => 60, 'C4' => 6],
            ],
            [
                'nama'       => 'SMP IT Ihsanul Fikri Batam',
                'npsn'       => '10100601',
                'jenis'      => 'Swasta',
                'akreditasi' => 'A',
                'alamat'     => 'Jl. Tiban Indah, Sekupang',
                'kecamatan'  => 'Sekupang',
                'biaya_spp'  => 650000,
                'fasilitas'  => ['Masjid','Lab Komputer','Perpustakaan','Lapangan','Tahfidz Room','Kantin Halal'],
                'desc'       => 'Sekolah Islam Terpadu dengan program boarding dan tahfidz intensif.',
                'jml_siswa'  => 360,
                'jml_guru'   => 28,
                'saw' => ['C1' => 650000, 'C2' => 100, 'C3' => 82, 'C4' => 9],
            ],
        ];

        $kriteriaMap = Kriteria::all()->keyBy('kode_kriteria');

        foreach ($schools as $s) {
            $fasilitas = json_encode($s['fasilitas']);

            $sekolah = SekolahRekomendasi::updateOrCreate(['npsn' => $s['npsn']], [
                'nama_sekolah'      => $s['nama'],
                'npsn'              => $s['npsn'],
                'jenis'             => $s['jenis'],
                'akreditasi'        => $s['akreditasi'],
                'alamat_sekolah'    => $s['alamat'],
                'kecamatan'         => $s['kecamatan'],
                'kota'              => 'Batam',
                'fasilitas_sekolah' => $fasilitas,
                'biaya_spp'         => $s['biaya_spp'],
                'deskripsi'         => $s['desc'],
                'jumlah_siswa'      => $s['jml_siswa'],
                'jumlah_guru'       => $s['jml_guru'],
                'is_active'         => true,
            ]);

            // Insert SAW scores
            foreach ($s['saw'] as $kode => $nilai) {
                $kriteria = $kriteriaMap[$kode] ?? null;
                if (!$kriteria) continue;

                NilaiKriteria::updateOrCreate(
                    ['sekolah_id' => $sekolah->id, 'kriteria_id' => $kriteria->id],
                    ['nilai' => $nilai]
                );
            }
        }
    }
}
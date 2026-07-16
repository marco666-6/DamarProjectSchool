<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use App\Models\NilaiKriteria;
use App\Models\SekolahRekomendasi;
use Illuminate\Database\Seeder;

class SekolahRekomendasiSeeder extends Seeder
{
    /**
     * C1 = Biaya SPP (cost)
     * C2 = Akreditasi (benefit)
     * C3 = Fasilitas (benefit)
     * C4 = Jarak / Lokasi (cost), calculated dynamically from user GPS input.
     */
    public function run(): void
    {
        $schools = [
            ['nama' => 'SMP Negeri 3 Batam', 'jenis' => 'Negeri', 'akreditasi' => 'A', 'alamat' => 'Jalan R.E. Martadinata, Sungai Harapan, Sekupang, Batam', 'kecamatan' => 'Sekupang', 'latitude' => 1.1065300, 'longitude' => 103.9525900, 'biaya_spp' => 0, 'fasilitas' => ['Perpustakaan', 'Laboratorium', 'Lapangan', 'UKS', 'Kantin'], 'desc' => 'Sekolah negeri di kawasan Sekupang. Koordinat seed diambil dari data OpenStreetMap/Nominatim.', 'akreditasi_score' => 100, 'fasilitas_score' => 78],
            ['nama' => 'SMP Negeri 6 Batam', 'jenis' => 'Negeri', 'akreditasi' => 'B', 'alamat' => 'Jalan Laksamana Bintan, Bengkong Indah, Bengkong, Batam', 'kecamatan' => 'Bengkong', 'latitude' => 1.1442500, 'longitude' => 104.0282049, 'biaya_spp' => 0, 'fasilitas' => ['Perpustakaan', 'Lapangan', 'UKS', 'Kantin'], 'desc' => 'Sekolah negeri di kawasan Bengkong. Koordinat seed diambil dari data OpenStreetMap/Nominatim.', 'akreditasi_score' => 80, 'fasilitas_score' => 68],
            ['nama' => 'SMP Negeri 9 Batam', 'jenis' => 'Negeri', 'akreditasi' => 'B', 'alamat' => 'Jalan Brigjen Katamso, Sagulung Kota, Sagulung, Batam', 'kecamatan' => 'Sagulung', 'latitude' => 1.0489201, 'longitude' => 103.9463087, 'biaya_spp' => 0, 'fasilitas' => ['Perpustakaan', 'Laboratorium', 'Lapangan', 'UKS'], 'desc' => 'Sekolah negeri di kawasan Sagulung. Koordinat seed diambil dari data OpenStreetMap/Nominatim.', 'akreditasi_score' => 80, 'fasilitas_score' => 72],
            ['nama' => 'SMP Negeri 20 Batam', 'jenis' => 'Negeri', 'akreditasi' => 'B', 'alamat' => 'Jalan Masuk Puskesmas, Tiban Baru, Sekupang, Batam', 'kecamatan' => 'Sekupang', 'latitude' => 1.1021700, 'longitude' => 103.9694600, 'biaya_spp' => 0, 'fasilitas' => ['Perpustakaan', 'Lapangan', 'UKS', 'Kantin'], 'desc' => 'Sekolah negeri di kawasan Tiban Baru. Koordinat seed diambil dari data OpenStreetMap/Nominatim.', 'akreditasi_score' => 80, 'fasilitas_score' => 70],
            ['nama' => 'SMP Negeri 31 Batam', 'jenis' => 'Negeri', 'akreditasi' => 'B', 'alamat' => 'Anggrek Sari, Taman Baloi, Batam Kota, Batam', 'kecamatan' => 'Batam Kota', 'latitude' => 1.1176882, 'longitude' => 104.0413321, 'biaya_spp' => 0, 'fasilitas' => ['Perpustakaan', 'Laboratorium', 'Lapangan', 'UKS'], 'desc' => 'Sekolah negeri di kawasan Batam Kota. Koordinat seed diambil dari data OpenStreetMap/Nominatim.', 'akreditasi_score' => 80, 'fasilitas_score' => 74],
            ['nama' => 'SMP Negeri 34 Batam', 'jenis' => 'Negeri', 'akreditasi' => 'B', 'alamat' => 'Jalan Hang Kesturi, Batu Besar, Nongsa, Batam', 'kecamatan' => 'Nongsa', 'latitude' => 1.1267798, 'longitude' => 104.1416686, 'biaya_spp' => 0, 'fasilitas' => ['Perpustakaan', 'Lapangan', 'UKS', 'Kantin'], 'desc' => 'Sekolah negeri di kawasan Nongsa. Koordinat seed diambil dari data OpenStreetMap/Nominatim.', 'akreditasi_score' => 80, 'fasilitas_score' => 66],
            ['nama' => 'SMP Negeri 47 Batam', 'jenis' => 'Negeri', 'akreditasi' => 'B', 'alamat' => 'Jalan Raya Marina City, Tanjung Riau, Sekupang, Batam', 'kecamatan' => 'Sekupang', 'latitude' => 1.0544415, 'longitude' => 103.9515270, 'biaya_spp' => 0, 'fasilitas' => ['Perpustakaan', 'Lapangan', 'UKS', 'Kantin'], 'desc' => 'Sekolah negeri di Tanjung Riau. Koordinat seed diambil dari data OpenStreetMap/Nominatim.', 'akreditasi_score' => 80, 'fasilitas_score' => 64],
            ['nama' => 'SMP Negeri 62 Batam', 'jenis' => 'Negeri', 'akreditasi' => 'B', 'alamat' => 'Gang Utama, Tanjung Buntung, Bengkong, Batam', 'kecamatan' => 'Bengkong', 'latitude' => 1.1679508, 'longitude' => 104.0291117, 'biaya_spp' => 0, 'fasilitas' => ['Perpustakaan', 'Lapangan', 'UKS', 'Kantin'], 'desc' => 'Sekolah negeri di Tanjung Buntung. Koordinat seed diambil dari data OpenStreetMap/Nominatim.', 'akreditasi_score' => 80, 'fasilitas_score' => 62],
            ['nama' => 'SD-SMP-SMA Muhammadiyah Batam', 'jenis' => 'Swasta', 'akreditasi' => 'B', 'alamat' => 'Tembesi Point, Kibing, Batu Aji, Batam', 'kecamatan' => 'Batu Aji', 'latitude' => 1.0451800, 'longitude' => 103.9900000, 'biaya_spp' => 350000, 'fasilitas' => ['Masjid', 'Perpustakaan', 'Lapangan', 'Kantin'], 'desc' => 'Kompleks sekolah Muhammadiyah di Batu Aji. Koordinat seed diambil dari data OpenStreetMap/Nominatim.', 'akreditasi_score' => 80, 'fasilitas_score' => 70],
        ];

        $kriteriaMap = Kriteria::all()->keyBy('kode_kriteria');

        foreach ($schools as $s) {
            $sekolah = SekolahRekomendasi::updateOrCreate(
                ['nama_sekolah' => $s['nama']],
                [
                    'npsn' => $s['npsn'] ?? null,
                    'jenis' => $s['jenis'],
                    'akreditasi' => $s['akreditasi'],
                    'alamat_sekolah' => $s['alamat'],
                    'kecamatan' => $s['kecamatan'],
                    'kota' => 'Batam',
                    'latitude' => $s['latitude'],
                    'longitude' => $s['longitude'],
                    'fasilitas_sekolah' => json_encode($s['fasilitas']),
                    'biaya_spp' => $s['biaya_spp'],
                    'deskripsi' => $s['desc'],
                    'is_active' => true,
                ]
            );

            $scores = ['C1' => $s['biaya_spp'], 'C2' => $s['akreditasi_score'], 'C3' => $s['fasilitas_score'], 'C4' => 0];

            foreach ($scores as $kode => $nilai) {
                $kriteria = $kriteriaMap[$kode] ?? null;
                if (!$kriteria) continue;

                $keterangan = match ($kode) {
                    'C1' => $nilai > 0 ? 'SPP Rp ' . number_format($nilai, 0, ',', '.') . '/bulan' : 'SPP gratis/negeri',
                    'C2' => 'Akreditasi ' . $s['akreditasi'] . ' (' . $nilai . ')',
                    'C3' => count($s['fasilitas']) . ' fasilitas utama, skor seed ' . $nilai,
                    'C4' => 'Dihitung otomatis dari lokasi rumah pengguna ke koordinat sekolah',
                    default => null,
                };

                NilaiKriteria::updateOrCreate(
                    ['sekolah_id' => $sekolah->id, 'kriteria_id' => $kriteria->id],
                    ['nilai' => $nilai, 'keterangan' => $keterangan]
                );
            }
        }
    }
}

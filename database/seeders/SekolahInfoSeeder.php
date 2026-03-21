<?php

namespace Database\Seeders;

use App\Models\SekolahInfo;
use Illuminate\Database\Seeder;

class SekolahInfoSeeder extends Seeder
{
    public function run(): void
    {
        SekolahInfo::updateOrCreate(['id' => 1], [
            'nama_sekolah'  => 'Batam Integrated Islamic School',
            'singkatan'     => 'BIIS',
            'visi'          => 'Menjadi sekolah Islam terpadu yang unggul, berkarakter, dan berdaya saing global.',
            'misi'          => json_encode([
                'Menyelenggarakan pendidikan berkualitas berbasis nilai-nilai Islam',
                'Mengembangkan potensi siswa secara holistik: akademik, spiritual, dan karakter',
                'Memberdayakan teknologi informasi dalam proses pembelajaran',
                'Membangun kemitraan strategis dengan orang tua dan masyarakat',
            ]),
            'sejarah'       => 'Batam Integrated Islamic School (BIIS) berdiri dengan visi menghadirkan pendidikan Islam terpadu yang berkualitas di Kota Batam. Sekolah ini didirikan untuk menjawab kebutuhan masyarakat akan lembaga pendidikan yang tidak hanya unggul secara akademik, tetapi juga kuat dalam pembentukan karakter Islami.',
            'kepala_sekolah'=> 'Ustadz Ahmad Fauzi, S.Pd., M.Ed.',
            'npsn'          => '10100001',
            'alamat'        => 'Jl. R. Patah No. 1, Batam Kota, Kota Batam',
            'kota'          => 'Batam',
            'provinsi'      => 'Kepulauan Riau',
            'kode_pos'      => '29432',
            'phone'         => '0778-123456',
            'email'         => 'info@biis.sch.id',
            'website'       => 'https://biis.sch.id',
            'akreditasi'    => 'A',
            'fasilitas'     => [
                'Masjid / Musholla',
                'Perpustakaan Digital',
                'Laboratorium IPA',
                'Laboratorium Komputer',
                'Ruang Tahfidz',
                'Lapangan Olahraga',
                'Kantin Sehat',
                'UKS',
                'CCTV',
                'WiFi',
            ],
        ]);
    }
}
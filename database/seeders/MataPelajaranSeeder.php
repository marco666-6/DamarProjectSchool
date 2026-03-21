<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\MataPelajaran;
use Illuminate\Database\Seeder;

class MataPelajaranSeeder extends Seeder
{
    public function run(): void
    {
        $guru = Guru::all()->keyBy('nama_guru');

        $mapel = [
            ['kode' => 'MTK',  'nama' => 'Matematika',              'kategori' => 'Wajib',         'guru' => 'Ahmad Fauzi, S.Pd.'],
            ['kode' => 'BIN',  'nama' => 'Bahasa Indonesia',        'kategori' => 'Wajib',         'guru' => 'Siti Aminah, S.Pd.'],
            ['kode' => 'IPA',  'nama' => 'Ilmu Pengetahuan Alam',   'kategori' => 'Wajib',         'guru' => 'Dewi Lestari, S.Pd.'],
            ['kode' => 'IPS',  'nama' => 'Ilmu Pengetahuan Sosial', 'kategori' => 'Wajib',         'guru' => null],
            ['kode' => 'PAI',  'nama' => 'Pendidikan Agama Islam',  'kategori' => 'Agama',         'guru' => 'Muhammad Rizki, S.Ag.'],
            ['kode' => 'THF',  'nama' => 'Tahfidz Al-Quran',        'kategori' => 'Agama',         'guru' => 'Muhammad Rizki, S.Ag.'],
            ['kode' => 'BIG',  'nama' => 'Bahasa Inggris',          'kategori' => 'Wajib',         'guru' => null],
            ['kode' => 'TIK',  'nama' => 'Teknologi Informasi',     'kategori' => 'Wajib',         'guru' => 'Hendra Kusuma, S.Kom.'],
            ['kode' => 'PKN',  'nama' => 'PKN',                     'kategori' => 'Wajib',         'guru' => null],
            ['kode' => 'PJOK', 'nama' => 'PJOK',                    'kategori' => 'Wajib',         'guru' => null],
            ['kode' => 'SBK',  'nama' => 'Seni Budaya & Prakarya', 'kategori' => 'Wajib',         'guru' => null],
            ['kode' => 'BDA',  'nama' => 'Bahasa Arab',             'kategori' => 'Muatan Lokal',  'guru' => 'Muhammad Rizki, S.Ag.'],
        ];

        foreach ($mapel as $m) {
            $guruId = null;
            if ($m['guru'] && isset($guru[$m['guru']])) {
                $guruId = $guru[$m['guru']]->id;
            }

            MataPelajaran::updateOrCreate(['kode_mapel' => $m['kode']], [
                'nama_mapel' => $m['nama'],
                'kode_mapel' => $m['kode'],
                'kategori'   => $m['kategori'],
                'guru_id'    => $guruId,
                'is_active'  => true,
            ]);
        }
    }
}
<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\Siswa;
use Illuminate\Database\Seeder;

class NilaiSeeder extends Seeder
{
    public function run(): void
    {
        $siswaList = Siswa::all();
        $mapelList = MataPelajaran::all();
        $guru      = Guru::first();
        $semester  = 'Ganjil 2024/2025';

        // Core subjects to seed
        $targetMapel = ['MTK', 'BIN', 'IPA', 'IPS', 'PAI', 'BIG'];
        $mapelFiltered = $mapelList->whereIn('kode_mapel', $targetMapel);

        foreach ($siswaList->take(10) as $siswa) {
            foreach ($mapelFiltered as $mapel) {
                $tugas     = rand(70, 95);
                $ujian     = rand(65, 95);
                $praktikum = rand(70, 95);
                $akhir     = round(($tugas * 0.3 + $ujian * 0.5 + $praktikum * 0.2), 2);

                Nilai::updateOrCreate(
                    ['siswa_id' => $siswa->id, 'mapel_id' => $mapel->id, 'semester' => $semester],
                    [
                        'guru_id'         => $guru?->id,
                        'nilai_tugas'     => $tugas,
                        'nilai_ujian'     => $ujian,
                        'nilai_praktikum' => $praktikum,
                        'nilai_akhir'     => $akhir,
                    ]
                );
            }
        }
    }
}
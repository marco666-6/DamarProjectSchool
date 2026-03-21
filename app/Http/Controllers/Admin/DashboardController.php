<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Kegiatan;
use App\Models\Kriteria;
use App\Models\Nilai;
use App\Models\Rekomendasi;
use App\Models\SekolahRekomendasi;
use App\Models\Siswa;
use App\Models\User;
use App\Services\SawService;

class DashboardController extends Controller
{
    public function index(SawService $saw)
    {
        $stats = [
            'total_siswa'    => Siswa::active()->count(),
            'total_guru'     => Guru::active()->count(),
            'total_user'     => User::users()->count(),
            'total_sekolah'  => SekolahRekomendasi::active()->count(),
            'total_kriteria' => Kriteria::active()->count(),
            'total_rekomendasi' => Rekomendasi::count(),
        ];

        $recentSiswa    = Siswa::latest()->take(5)->get();
        $recentGuru     = Guru::latest()->take(5)->get();
        $recentRekomen  = Rekomendasi::with('user')->latest()->take(5)->get();

        $bobotCheck = $saw->validateBobotSum();

        // Siswa per kelas breakdown
        $kelasStats = Siswa::active()
            ->selectRaw('kelas, count(*) as total')
            ->groupBy('kelas')
            ->orderBy('kelas')
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentSiswa',
            'recentGuru',
            'recentRekomen',
            'bobotCheck',
            'kelasStats'
        ));
    }
}
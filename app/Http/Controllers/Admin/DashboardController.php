<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Kegiatan;
use App\Models\Kriteria;
use App\Models\Nilai;
use App\Models\Rekomendasi;
use App\Models\SekolahInfo;
use App\Models\SekolahRekomendasi;
use App\Models\Siswa;
use App\Models\User;
use App\Services\SawService;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(SawService $saw)
    {
        $school = SekolahInfo::getInstance();

        $stats = [
            'total_siswa'    => Siswa::active()->count(),
            'total_guru'     => Guru::active()->count(),
            'total_user'     => User::users()->count(),
            'total_sekolah'  => SekolahRekomendasi::active()->count(),
            'total_kriteria' => Kriteria::active()->count(),
            'total_rekomendasi' => Rekomendasi::count(),
            'avg_nilai'      => round((float) (Nilai::avg('nilai_akhir') ?? 0), 1),
            'total_kegiatan' => Kegiatan::count(),
        ];

        $recentSiswa    = Siswa::latest()->take(5)->get();
        $recentGuru     = Guru::latest()->take(5)->get();
        $recentRekomen  = Rekomendasi::with('user')->latest()->take(5)->get();
        $recentKegiatan = Kegiatan::with(['siswa', 'guru'])
            ->orderByDesc(DB::raw('COALESCE(tanggal_kegiatan, created_at)'))
            ->take(6)
            ->get();

        $bobotCheck = $saw->validateBobotSum();

        $kelasStats = Siswa::active()
            ->selectRaw('kelas, count(*) as total')
            ->whereNotNull('kelas')
            ->groupBy('kelas')
            ->orderBy('kelas')
            ->get();

        $genderStats = Siswa::active()
            ->selectRaw('COALESCE(jenis_kelamin, "N/A") as label, count(*) as total')
            ->groupBy('label')
            ->get();

        $nilaiTrend = Nilai::selectRaw('semester, AVG(nilai_akhir) as average_score, COUNT(*) as total_records')
            ->whereNotNull('nilai_akhir')
            ->groupBy('semester')
            ->orderBy('semester')
            ->get();

        $kegiatanStats = Kegiatan::selectRaw('jenis_kegiatan, count(*) as total')
            ->groupBy('jenis_kegiatan')
            ->orderByDesc('total')
            ->get();

        $schoolAccreditationStats = SekolahRekomendasi::active()
            ->selectRaw('akreditasi, count(*) as total')
            ->groupBy('akreditasi')
            ->orderBy('akreditasi')
            ->get();

        $topStudents = Siswa::active()
            ->withAvg('nilai as average_nilai', 'nilai_akhir')
            ->withCount('kegiatan')
            ->orderByDesc('average_nilai')
            ->orderByDesc('kegiatan_count')
            ->take(6)
            ->get();

        $quickActions = [
            ['label' => 'Tambah Siswa', 'route' => route('admin.siswa.create'), 'icon' => 'bi-person-plus', 'tone' => 'success'],
            ['label' => 'Kelola Guru', 'route' => route('admin.guru.index'), 'icon' => 'bi-person-badge', 'tone' => 'primary'],
            ['label' => 'Input Nilai', 'route' => route('admin.nilai.create'), 'icon' => 'bi-journal-plus', 'tone' => 'warning'],
            ['label' => 'Atur Profil Sekolah', 'route' => route('admin.sekolah-info.edit'), 'icon' => 'bi-building-gear', 'tone' => 'info'],
        ];

        return view('admin.dashboard', compact(
            'school',
            'stats',
            'recentSiswa',
            'recentGuru',
            'recentRekomen',
            'recentKegiatan',
            'bobotCheck',
            'kelasStats',
            'genderStats',
            'nilaiTrend',
            'kegiatanStats',
            'schoolAccreditationStats',
            'topStudents',
            'quickActions'
        ));
    }
}

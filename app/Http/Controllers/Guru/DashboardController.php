<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\Nilai;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $guru = Auth::user()->guru;
        $mapelIds = $guru->mataPelajaran()->pluck('id');

        $stats = [
            'total_nilai'    => Nilai::where('guru_id', $guru->id)->count(),
            'total_kegiatan' => Kegiatan::where('guru_id', $guru->id)->count(),
            'total_siswa'    => Siswa::active()->count(),
            'total_mapel'    => $guru->mataPelajaran()->count(),
            'avg_nilai'      => round((float) (Nilai::where('guru_id', $guru->id)->avg('nilai_akhir') ?? 0), 1),
            'prestasi'       => Kegiatan::where('guru_id', $guru->id)->whereNotNull('prestasi')->count(),
        ];

        $recentNilai    = Nilai::with(['siswa', 'mataPelajaran'])
            ->where('guru_id', $guru->id)
            ->latest()->take(5)->get();

        $recentKegiatan = Kegiatan::with('siswa')
            ->where('guru_id', $guru->id)
            ->latest('tanggal_kegiatan')->take(5)->get();

        $nilaiPerMapel = Nilai::with('mataPelajaran')
            ->selectRaw('mapel_id, AVG(nilai_akhir) as average_score, COUNT(*) as total_records')
            ->where('guru_id', $guru->id)
            ->whereIn('mapel_id', $mapelIds)
            ->groupBy('mapel_id')
            ->orderByDesc('average_score')
            ->get();

        $kegiatanPerJenis = Kegiatan::selectRaw('jenis_kegiatan, COUNT(*) as total')
            ->where('guru_id', $guru->id)
            ->groupBy('jenis_kegiatan')
            ->orderByDesc('total')
            ->get();

        $semesterTrend = Nilai::selectRaw('semester, AVG(nilai_akhir) as average_score, COUNT(*) as total_records')
            ->where('guru_id', $guru->id)
            ->groupBy('semester')
            ->orderBy('semester')
            ->get();

        $studentHighlights = Siswa::active()
            ->whereHas('nilai', fn ($query) => $query->where('guru_id', $guru->id))
            ->withAvg(['nilai as average_nilai' => fn ($query) => $query->where('guru_id', $guru->id)], 'nilai_akhir')
            ->withCount(['kegiatan as kegiatan_bersama' => fn ($query) => $query->where('guru_id', $guru->id)])
            ->orderByDesc('average_nilai')
            ->take(6)
            ->get();

        $quickActions = [
            ['label' => 'Tambah Nilai', 'route' => route('guru.nilai.create'), 'icon' => 'bi-journal-plus', 'tone' => 'success'],
            ['label' => 'Tambah Kegiatan', 'route' => route('guru.kegiatan.create'), 'icon' => 'bi-calendar-plus', 'tone' => 'warning'],
            ['label' => 'Lihat Data Siswa', 'route' => route('guru.siswa.index'), 'icon' => 'bi-people', 'tone' => 'primary'],
            ['label' => 'Profil Sekolah', 'route' => route('guru.sekolah'), 'icon' => 'bi-building', 'tone' => 'info'],
        ];

        return view('guru.dashboard', compact(
            'guru',
            'stats',
            'recentNilai',
            'recentKegiatan',
            'nilaiPerMapel',
            'kegiatanPerJenis',
            'semesterTrend',
            'studentHighlights',
            'quickActions'
        ));
    }
}

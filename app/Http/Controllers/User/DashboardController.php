<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\Nilai;
use App\Models\Rekomendasi;
use App\Models\Siswa;
use App\Models\SekolahInfo;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user       = Auth::user();
        $sekolahInfo = SekolahInfo::getInstance();

        $siswaList  = Siswa::where('user_id', $user->id)->with(['nilai', 'kegiatan'])->get();
        $siswaIds = $siswaList->pluck('id');

        $lastRekomen = Rekomendasi::where('user_id', $user->id)
            ->latest()->first();

        $stats = [
            'jumlah_anak' => $siswaList->count(),
            'rata_nilai' => round((float) (Nilai::whereIn('siswa_id', $siswaIds)->avg('nilai_akhir') ?? 0), 1),
            'jumlah_kegiatan' => Kegiatan::whereIn('siswa_id', $siswaIds)->count(),
            'riwayat_rekomendasi' => Rekomendasi::where('user_id', $user->id)->count(),
        ];

        $recentNilai = Nilai::with(['siswa', 'mataPelajaran'])
            ->whereIn('siswa_id', $siswaIds)
            ->latest()
            ->take(6)
            ->get();

        $recentActivities = Kegiatan::with('siswa')
            ->whereIn('siswa_id', $siswaIds)
            ->latest('tanggal_kegiatan')
            ->take(6)
            ->get();

        $nilaiTrend = Nilai::selectRaw('semester, AVG(nilai_akhir) as average_score, COUNT(*) as total_records')
            ->whereIn('siswa_id', $siswaIds)
            ->groupBy('semester')
            ->orderBy('semester')
            ->get();

        $activityBreakdown = Kegiatan::selectRaw('jenis_kegiatan, COUNT(*) as total')
            ->whereIn('siswa_id', $siswaIds)
            ->groupBy('jenis_kegiatan')
            ->orderByDesc('total')
            ->get();

        $recommendationHistory = Rekomendasi::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $quickActions = [
            ['label' => 'Cari Rekomendasi', 'route' => route('user.rekomendasi.form'), 'icon' => 'bi-search', 'tone' => 'success'],
            ['label' => 'Lihat Nilai', 'route' => route('user.data.nilai'), 'icon' => 'bi-journal-text', 'tone' => 'primary'],
            ['label' => 'Kegiatan Anak', 'route' => route('user.data.kegiatan'), 'icon' => 'bi-calendar-event', 'tone' => 'warning'],
            ['label' => 'Profil Sekolah', 'route' => route('user.data.sekolah'), 'icon' => 'bi-building', 'tone' => 'info'],
        ];

        return view('user.dashboard', compact(
            'user',
            'sekolahInfo',
            'siswaList',
            'lastRekomen',
            'stats',
            'recentNilai',
            'recentActivities',
            'nilaiTrend',
            'activityBreakdown',
            'recommendationHistory',
            'quickActions'
        ));
    }
}

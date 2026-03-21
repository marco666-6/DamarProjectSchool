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

        $stats = [
            'total_nilai'    => Nilai::where('guru_id', $guru->id)->count(),
            'total_kegiatan' => Kegiatan::where('guru_id', $guru->id)->count(),
            'total_siswa'    => Siswa::active()->count(),
            'total_mapel'    => $guru->mataPelajaran()->count(),
        ];

        $recentNilai    = Nilai::with(['siswa', 'mataPelajaran'])
            ->where('guru_id', $guru->id)
            ->latest()->take(5)->get();

        $recentKegiatan = Kegiatan::with('siswa')
            ->where('guru_id', $guru->id)
            ->latest('tanggal_kegiatan')->take(5)->get();

        return view('guru.dashboard', compact('guru', 'stats', 'recentNilai', 'recentKegiatan'));
    }
}
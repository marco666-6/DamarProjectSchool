<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Kegiatan;
use App\Models\Nilai;
use App\Models\SekolahInfo;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataController extends Controller
{
    // ── Sekolah Info ──────────────────────────────────────────────────────────
    public function sekolah()
    {
        $sekolahInfo = SekolahInfo::getInstance();
        return view('user.data.sekolah', compact('sekolahInfo'));
    }

    // ── Siswa ─────────────────────────────────────────────────────────────────
    public function siswa(Request $request)
    {
        $query = Siswa::active();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_siswa', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        if ($kelas = $request->get('kelas')) {
            $query->where('kelas', $kelas);
        }

        $siswaList = $query->orderBy('nama_siswa')->paginate(20)->withQueryString();
        $kelasList = Siswa::active()->distinct()->orderBy('kelas')->pluck('kelas');

        return view('user.data.siswa', compact('siswaList', 'kelasList'));
    }

    public function siswaShow(Siswa $siswa)
    {
        $siswa->load(['nilai.mataPelajaran', 'kegiatan']);
        return view('user.data.siswa-show', compact('siswa'));
    }

    // ── Guru ──────────────────────────────────────────────────────────────────
    public function guru(Request $request)
    {
        $query = Guru::active()->with('mataPelajaran');

        if ($search = $request->get('search')) {
            $query->where('nama_guru', 'like', "%{$search}%");
        }

        $guruList = $query->orderBy('nama_guru')->paginate(20)->withQueryString();

        return view('user.data.guru', compact('guruList'));
    }

    // ── Nilai ─────────────────────────────────────────────────────────────────
    public function nilai(Request $request)
    {
        $user  = Auth::user();
        // Users can see their own children's grades
        $siswaIds = Siswa::where('user_id', $user->id)->pluck('id');

        $query = Nilai::with(['siswa', 'mataPelajaran'])
            ->whereIn('siswa_id', $siswaIds);

        if ($search = $request->get('search')) {
            $query->whereHas('siswa', fn($q) => $q->where('nama_siswa', 'like', "%{$search}%"));
        }

        if ($semester = $request->get('semester')) {
            $query->where('semester', $semester);
        }

        $nilaiList = $query->latest()->paginate(20)->withQueryString();
        $semesters = Nilai::whereIn('siswa_id', $siswaIds)->distinct()->pluck('semester');

        return view('user.data.nilai', compact('nilaiList', 'semesters'));
    }

    // ── Kegiatan ──────────────────────────────────────────────────────────────
    public function kegiatan(Request $request)
    {
        $user     = Auth::user();
        $siswaIds = Siswa::where('user_id', $user->id)->pluck('id');

        $query = Kegiatan::with('siswa')
            ->whereIn('siswa_id', $siswaIds);

        if ($search = $request->get('search')) {
            $query->where('nama_kegiatan', 'like', "%{$search}%");
        }

        if ($jenis = $request->get('jenis_kegiatan')) {
            $query->where('jenis_kegiatan', $jenis);
        }

        $kegiatanList = $query->latest('tanggal_kegiatan')->paginate(20)->withQueryString();
        $jenisOptions = ['Akademik', 'Non-Akademik', 'Ekstrakurikuler', 'Keagamaan', 'Sosial', 'Tahfidz', 'Lainnya'];

        return view('user.data.kegiatan', compact('kegiatanList', 'jenisOptions'));
    }
}
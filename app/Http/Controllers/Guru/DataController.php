<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\SekolahInfo;
use App\Models\Siswa;
use Illuminate\Http\Request;

class DataController extends Controller
{
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

        return view('guru.data.siswa', compact('siswaList', 'kelasList'));
    }

    public function siswaShow(Siswa $siswa)
    {
        $siswa->load(['nilai.mataPelajaran', 'kegiatan']);
        return view('guru.data.siswa-show', compact('siswa'));
    }

    public function sekolah()
    {
        $sekolahInfo = SekolahInfo::getInstance();
        return view('guru.data.sekolah', compact('sekolahInfo'));
    }
}
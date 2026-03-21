<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KegiatanController extends Controller
{
    private function getGuru()
    {
        return Auth::user()->guru;
    }

    public function index(Request $request)
    {
        $guru  = $this->getGuru();
        $query = Kegiatan::with('siswa')->where('guru_id', $guru->id);

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_kegiatan', 'like', "%{$search}%")
                  ->orWhereHas('siswa', fn($sq) => $sq->where('nama_siswa', 'like', "%{$search}%"));
            });
        }

        if ($jenis = $request->get('jenis_kegiatan')) {
            $query->where('jenis_kegiatan', $jenis);
        }

        $kegiatanList = $query->latest('tanggal_kegiatan')->paginate(20)->withQueryString();
        $jenisOptions = ['Akademik', 'Non-Akademik', 'Ekstrakurikuler', 'Keagamaan', 'Sosial', 'Tahfidz', 'Lainnya'];

        return view('guru.kegiatan.index', compact('kegiatanList', 'jenisOptions'));
    }

    public function create()
    {
        $siswaList    = Siswa::active()->orderBy('nama_siswa')->get();
        $jenisOptions = ['Akademik', 'Non-Akademik', 'Ekstrakurikuler', 'Keagamaan', 'Sosial', 'Tahfidz', 'Lainnya'];
        return view('guru.kegiatan.create', compact('siswaList', 'jenisOptions'));
    }

    public function store(Request $request)
    {
        $guru = $this->getGuru();

        $data = $request->validate([
            'siswa_id'         => ['required', 'exists:siswa,id'],
            'nama_kegiatan'    => ['required', 'string', 'max:255'],
            'jenis_kegiatan'   => ['required', 'in:Akademik,Non-Akademik,Ekstrakurikuler,Keagamaan,Sosial,Tahfidz,Lainnya'],
            'tanggal_kegiatan' => ['nullable', 'date'],
            'deskripsi'        => ['nullable', 'string'],
            'prestasi'         => ['nullable', 'string', 'max:100'],
            'tingkat'          => ['nullable', 'string', 'max:50'],
        ]);

        $data['guru_id'] = $guru->id;
        Kegiatan::create($data);

        return redirect()->route('guru.kegiatan.index')
            ->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function edit(Kegiatan $kegiatan)
    {
        $guru = $this->getGuru();
        if ($kegiatan->guru_id && $kegiatan->guru_id !== $guru->id) {
            abort(403);
        }
        $siswaList    = Siswa::active()->orderBy('nama_siswa')->get();
        $jenisOptions = ['Akademik', 'Non-Akademik', 'Ekstrakurikuler', 'Keagamaan', 'Sosial', 'Tahfidz', 'Lainnya'];
        return view('guru.kegiatan.edit', compact('kegiatan', 'siswaList', 'jenisOptions'));
    }

    public function update(Request $request, Kegiatan $kegiatan)
    {
        $guru = $this->getGuru();
        if ($kegiatan->guru_id && $kegiatan->guru_id !== $guru->id) abort(403);

        $data = $request->validate([
            'siswa_id'         => ['required', 'exists:siswa,id'],
            'nama_kegiatan'    => ['required', 'string', 'max:255'],
            'jenis_kegiatan'   => ['required', 'in:Akademik,Non-Akademik,Ekstrakurikuler,Keagamaan,Sosial,Tahfidz,Lainnya'],
            'tanggal_kegiatan' => ['nullable', 'date'],
            'deskripsi'        => ['nullable', 'string'],
            'prestasi'         => ['nullable', 'string', 'max:100'],
            'tingkat'          => ['nullable', 'string', 'max:50'],
        ]);

        $kegiatan->update($data);
        return redirect()->route('guru.kegiatan.index')->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy(Kegiatan $kegiatan)
    {
        $guru = $this->getGuru();
        if ($kegiatan->guru_id && $kegiatan->guru_id !== $guru->id) abort(403);
        $kegiatan->delete();
        return redirect()->route('guru.kegiatan.index')->with('success', 'Kegiatan berhasil dihapus.');
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Kegiatan;
use App\Models\Siswa;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    public function index(Request $request)
    {
        $query = Kegiatan::with(['siswa', 'guru']);

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

        return view('admin.kegiatan.index', compact('kegiatanList', 'jenisOptions'));
    }

    public function create()
    {
        $siswaList = Siswa::active()->orderBy('nama_siswa')->get();
        $guruList  = Guru::active()->orderBy('nama_guru')->get();
        $jenisOptions = ['Akademik', 'Non-Akademik', 'Ekstrakurikuler', 'Keagamaan', 'Sosial', 'Tahfidz', 'Lainnya'];
        return view('admin.kegiatan.create', compact('siswaList', 'guruList', 'jenisOptions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'siswa_id'         => ['required', 'exists:siswa,id'],
            'guru_id'          => ['nullable', 'exists:guru,id'],
            'nama_kegiatan'    => ['required', 'string', 'max:255'],
            'jenis_kegiatan'   => ['required', 'in:Akademik,Non-Akademik,Ekstrakurikuler,Keagamaan,Sosial,Tahfidz,Lainnya'],
            'tanggal_kegiatan' => ['nullable', 'date'],
            'deskripsi'        => ['nullable', 'string'],
            'prestasi'         => ['nullable', 'string', 'max:100'],
            'tingkat'          => ['nullable', 'string', 'max:50'],
        ]);

        Kegiatan::create($data);

        return redirect()->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function edit(Kegiatan $kegiatan)
    {
        $siswaList = Siswa::active()->orderBy('nama_siswa')->get();
        $guruList  = Guru::active()->orderBy('nama_guru')->get();
        $jenisOptions = ['Akademik', 'Non-Akademik', 'Ekstrakurikuler', 'Keagamaan', 'Sosial', 'Tahfidz', 'Lainnya'];
        return view('admin.kegiatan.edit', compact('kegiatan', 'siswaList', 'guruList', 'jenisOptions'));
    }

    public function update(Request $request, Kegiatan $kegiatan)
    {
        $data = $request->validate([
            'siswa_id'         => ['required', 'exists:siswa,id'],
            'guru_id'          => ['nullable', 'exists:guru,id'],
            'nama_kegiatan'    => ['required', 'string', 'max:255'],
            'jenis_kegiatan'   => ['required', 'in:Akademik,Non-Akademik,Ekstrakurikuler,Keagamaan,Sosial,Tahfidz,Lainnya'],
            'tanggal_kegiatan' => ['nullable', 'date'],
            'deskripsi'        => ['nullable', 'string'],
            'prestasi'         => ['nullable', 'string', 'max:100'],
            'tingkat'          => ['nullable', 'string', 'max:50'],
        ]);

        $kegiatan->update($data);

        return redirect()->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy(Kegiatan $kegiatan)
    {
        $kegiatan->delete();
        return redirect()->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil dihapus.');
    }
}
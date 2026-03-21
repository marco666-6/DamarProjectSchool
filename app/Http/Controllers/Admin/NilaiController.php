<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\Siswa;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $query = Nilai::with(['siswa', 'mataPelajaran', 'guru']);

        if ($search = $request->get('search')) {
            $query->whereHas('siswa', fn($q) => $q->where('nama_siswa', 'like', "%{$search}%"));
        }

        if ($mapelId = $request->get('mapel_id')) {
            $query->where('mapel_id', $mapelId);
        }

        if ($semester = $request->get('semester')) {
            $query->where('semester', $semester);
        }

        if ($kelas = $request->get('kelas')) {
            $query->whereHas('siswa', fn($q) => $q->where('kelas', $kelas));
        }

        $nilaiList  = $query->latest()->paginate(20)->withQueryString();
        $mapelList  = MataPelajaran::active()->get();
        $kelasList  = Siswa::active()->distinct()->orderBy('kelas')->pluck('kelas');
        $semesters  = Nilai::distinct()->orderBy('semester')->pluck('semester');

        return view('admin.nilai.index', compact('nilaiList', 'mapelList', 'kelasList', 'semesters'));
    }

    public function create()
    {
        $siswaList = Siswa::active()->orderBy('nama_siswa')->get();
        $mapelList = MataPelajaran::active()->orderBy('nama_mapel')->get();
        $guruList  = Guru::active()->orderBy('nama_guru')->get();
        return view('admin.nilai.create', compact('siswaList', 'mapelList', 'guruList'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'siswa_id'        => ['required', 'exists:siswa,id'],
            'mapel_id'        => ['required', 'exists:mata_pelajaran,id'],
            'guru_id'         => ['nullable', 'exists:guru,id'],
            'semester'        => ['required', 'string', 'max:50'],
            'nilai_tugas'     => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai_ujian'     => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai_praktikum' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'catatan'         => ['nullable', 'string'],
        ]);

        // Auto-calculate nilai_akhir
        $nilai = new Nilai($data);
        $data['nilai_akhir'] = $nilai->hitungNilaiAkhir();

        Nilai::updateOrCreate(
            ['siswa_id' => $data['siswa_id'], 'mapel_id' => $data['mapel_id'], 'semester' => $data['semester']],
            $data
        );

        return redirect()->route('admin.nilai.index')
            ->with('success', 'Nilai berhasil disimpan.');
    }

    public function edit(Nilai $nilai)
    {
        $siswaList = Siswa::active()->orderBy('nama_siswa')->get();
        $mapelList = MataPelajaran::active()->orderBy('nama_mapel')->get();
        $guruList  = Guru::active()->orderBy('nama_guru')->get();
        return view('admin.nilai.edit', compact('nilai', 'siswaList', 'mapelList', 'guruList'));
    }

    public function update(Request $request, Nilai $nilai)
    {
        $data = $request->validate([
            'guru_id'         => ['nullable', 'exists:guru,id'],
            'semester'        => ['required', 'string', 'max:50'],
            'nilai_tugas'     => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai_ujian'     => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai_praktikum' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'catatan'         => ['nullable', 'string'],
        ]);

        $tempNilai = new Nilai($data);
        $data['nilai_akhir'] = $tempNilai->hitungNilaiAkhir();

        $nilai->update($data);

        return redirect()->route('admin.nilai.index')
            ->with('success', 'Nilai berhasil diperbarui.');
    }

    public function destroy(Nilai $nilai)
    {
        $nilai->delete();
        return redirect()->route('admin.nilai.index')
            ->with('success', 'Nilai berhasil dihapus.');
    }
}
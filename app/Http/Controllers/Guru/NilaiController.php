<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    private function getGuru()
    {
        return Auth::user()->guru;
    }

    public function index(Request $request)
    {
        $guru  = $this->getGuru();
        $query = Nilai::with(['siswa', 'mataPelajaran'])->where('guru_id', $guru->id);

        if ($search = $request->get('search')) {
            $query->whereHas('siswa', fn($q) => $q->where('nama_siswa', 'like', "%{$search}%"));
        }

        if ($mapelId = $request->get('mapel_id')) {
            $query->where('mapel_id', $mapelId);
        }

        if ($semester = $request->get('semester')) {
            $query->where('semester', $semester);
        }

        $nilaiList = $query->latest()->paginate(20)->withQueryString();
        $mapelList = $guru->mataPelajaran()->active()->get();
        $semesters = Nilai::where('guru_id', $guru->id)->distinct()->pluck('semester');

        return view('guru.nilai.index', compact('nilaiList', 'mapelList', 'semesters'));
    }

    public function create()
    {
        $guru      = $this->getGuru();
        $siswaList = Siswa::active()->orderBy('nama_siswa')->get();
        $mapelList = $guru->mataPelajaran()->active()->orderBy('nama_mapel')->get();

        // If guru has no mapel, show all mapel
        if ($mapelList->isEmpty()) {
            $mapelList = MataPelajaran::active()->orderBy('nama_mapel')->get();
        }

        return view('guru.nilai.create', compact('siswaList', 'mapelList', 'guru'));
    }

    public function store(Request $request)
    {
        $guru = $this->getGuru();

        $data = $request->validate([
            'siswa_id'        => ['required', 'exists:siswa,id'],
            'mapel_id'        => ['required', 'exists:mata_pelajaran,id'],
            'semester'        => ['required', 'string', 'max:50'],
            'nilai_tugas'     => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai_ujian'     => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai_praktikum' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'catatan'         => ['nullable', 'string'],
        ]);

        $data['guru_id'] = $guru->id;
        $tempNilai = new Nilai($data);
        $data['nilai_akhir'] = $tempNilai->hitungNilaiAkhir();

        Nilai::updateOrCreate(
            ['siswa_id' => $data['siswa_id'], 'mapel_id' => $data['mapel_id'], 'semester' => $data['semester']],
            $data
        );

        return redirect()->route('guru.nilai.index')
            ->with('success', 'Nilai berhasil disimpan.');
    }

    public function edit(Nilai $nilai)
    {
        $guru = $this->getGuru();

        // Guru can only edit their own entries
        if ($nilai->guru_id && $nilai->guru_id !== $guru->id) {
            abort(403, 'Anda tidak berhak mengedit nilai ini.');
        }

        $siswaList = Siswa::active()->orderBy('nama_siswa')->get();
        $mapelList = MataPelajaran::active()->orderBy('nama_mapel')->get();

        return view('guru.nilai.edit', compact('nilai', 'siswaList', 'mapelList'));
    }

    public function update(Request $request, Nilai $nilai)
    {
        $guru = $this->getGuru();
        if ($nilai->guru_id && $nilai->guru_id !== $guru->id) {
            abort(403);
        }

        $data = $request->validate([
            'semester'        => ['required', 'string', 'max:50'],
            'nilai_tugas'     => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai_ujian'     => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai_praktikum' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'catatan'         => ['nullable', 'string'],
        ]);

        $tempNilai = new Nilai($data);
        $data['nilai_akhir'] = $tempNilai->hitungNilaiAkhir();

        $nilai->update($data);

        return redirect()->route('guru.nilai.index')
            ->with('success', 'Nilai berhasil diperbarui.');
    }

    public function destroy(Nilai $nilai)
    {
        $guru = $this->getGuru();
        if ($nilai->guru_id && $nilai->guru_id !== $guru->id) {
            abort(403);
        }
        $nilai->delete();
        return redirect()->route('guru.nilai.index')
            ->with('success', 'Nilai berhasil dihapus.');
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\Siswa;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $this->resolvePerPage($request);

        $query = Nilai::query()
            ->join('siswa', 'nilai.siswa_id', '=', 'siswa.id')
            ->selectRaw('
                nilai.siswa_id,
                nilai.semester,
                siswa.nama_siswa,
                siswa.kelas,
                COUNT(nilai.id) as total_mapel,
                AVG(nilai.nilai_akhir) as rata_nilai,
                MAX(nilai.updated_at) as terakhir_diubah
            ')
            ->groupBy('nilai.siswa_id', 'nilai.semester', 'siswa.nama_siswa', 'siswa.kelas');

        if ($search = $request->get('search')) {
            $query->where(function ($builder) use ($search) {
                $builder->where('siswa.nama_siswa', 'like', "%{$search}%")
                    ->orWhere('siswa.nisn', 'like', "%{$search}%");
            });
        }

        if ($mapelId = $request->get('mapel_id')) {
            $query->where('nilai.mapel_id', $mapelId);
        }

        if ($semester = $request->get('semester')) {
            $query->where('nilai.semester', $semester);
        }

        if ($kelas = $request->get('kelas')) {
            $query->where('siswa.kelas', $kelas);
        }

        $nilaiList = $query
            ->orderBy('siswa.nama_siswa')
            ->orderByDesc('nilai.semester')
            ->paginate($perPage)
            ->withQueryString();

        $mapelList = MataPelajaran::active()->orderBy('nama_mapel')->get();
        $kelasList = Siswa::active()->distinct()->orderBy('kelas')->pluck('kelas');
        $semesters = Nilai::distinct()->orderByDesc('semester')->pluck('semester');

        return view('admin.nilai.index', compact('nilaiList', 'mapelList', 'kelasList', 'semesters', 'perPage'));
    }

    public function create(Request $request)
    {
        $siswaList = Siswa::active()->orderBy('nama_siswa')->get();
        $mapelList = MataPelajaran::active()->with('guru')->orderBy('nama_mapel')->get();

        $selectedSiswa = null;
        $selectedSemester = $request->query('semester', 'Ganjil ' . date('Y') . '/' . (date('Y') + 1));
        $nilaiMap = collect();

        if ($request->filled('siswa_id')) {
            $selectedSiswa = Siswa::active()->find($request->integer('siswa_id'));

            if ($selectedSiswa) {
                $nilaiMap = Nilai::where('siswa_id', $selectedSiswa->id)
                    ->where('semester', $selectedSemester)
                    ->get()
                    ->keyBy('mapel_id');
            }
        }

        return view('admin.nilai.create', compact('siswaList', 'mapelList', 'selectedSiswa', 'selectedSemester', 'nilaiMap'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'siswa_id' => ['required', 'exists:siswa,id'],
            'semester' => ['required', 'string', 'max:50'],
            'nilai' => ['required', 'array'],
            'nilai.*.nilai_tugas' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai.*.nilai_ujian' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai.*.nilai_praktikum' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai.*.catatan' => ['nullable', 'string'],
            'nilai.*.hapus' => ['nullable', 'boolean'],
        ]);

        $mapelList = MataPelajaran::active()->get()->keyBy('id');
        $savedCount = 0;
        $deletedCount = 0;

        foreach ($data['nilai'] as $mapelId => $row) {
            $mapel = $mapelList->get((int) $mapelId);

            if (!$mapel) {
                continue;
            }

            $existing = Nilai::where('siswa_id', $data['siswa_id'])
                ->where('mapel_id', $mapel->id)
                ->where('semester', $data['semester'])
                ->first();

            if (!empty($row['hapus'])) {
                if ($existing) {
                    $existing->delete();
                    $deletedCount++;
                }
                continue;
            }

            $hasValue = collect([
                $row['nilai_tugas'] ?? null,
                $row['nilai_ujian'] ?? null,
                $row['nilai_praktikum'] ?? null,
                $row['catatan'] ?? null,
            ])->filter(fn ($value) => $value !== null && $value !== '')->isNotEmpty();

            if (!$hasValue) {
                continue;
            }

            $payload = [
                'siswa_id' => $data['siswa_id'],
                'mapel_id' => $mapel->id,
                'guru_id' => $mapel->guru_id,
                'semester' => $data['semester'],
                'nilai_tugas' => $row['nilai_tugas'] ?? null,
                'nilai_ujian' => $row['nilai_ujian'] ?? null,
                'nilai_praktikum' => $row['nilai_praktikum'] ?? null,
                'catatan' => $row['catatan'] ?? null,
            ];

            $tempNilai = new Nilai($payload);
            $payload['nilai_akhir'] = $tempNilai->hitungNilaiAkhir();

            Nilai::updateOrCreate(
                [
                    'siswa_id' => $payload['siswa_id'],
                    'mapel_id' => $payload['mapel_id'],
                    'semester' => $payload['semester'],
                ],
                $payload
            );

            $savedCount++;
        }

        return redirect()->route('admin.nilai.index', [
            'search' => Siswa::find($data['siswa_id'])?->nama_siswa,
            'semester' => $data['semester'],
        ])->with('success', $this->buildBatchMessage($savedCount, $deletedCount));
    }

    public function edit(Nilai $nilai)
    {
        return redirect()->route('admin.nilai.create', [
            'siswa_id' => $nilai->siswa_id,
            'semester' => $nilai->semester,
        ]);
    }

    public function update(Request $request, Nilai $nilai)
    {
        $payload = $request->validate([
            'semester' => ['required', 'string', 'max:50'],
            'nilai_tugas' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai_ujian' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai_praktikum' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'catatan' => ['nullable', 'string'],
        ]);

        $tempNilai = new Nilai($payload);
        $payload['nilai_akhir'] = $tempNilai->hitungNilaiAkhir();
        $nilai->update($payload);

        return redirect()->route('admin.nilai.create', [
            'siswa_id' => $nilai->siswa_id,
            'semester' => $payload['semester'],
        ])->with('success', 'Nilai berhasil diperbarui.');
    }

    public function destroy(Nilai $nilai)
    {
        $nilai->delete();

        return redirect()->route('admin.nilai.index')
            ->with('success', 'Nilai berhasil dihapus.');
    }

    private function resolvePerPage(Request $request): int
    {
        $perPage = (int) $request->get('per_page', 20);

        return in_array($perPage, [10, 20, 50, 100], true) ? $perPage : 20;
    }

    private function buildBatchMessage(int $savedCount, int $deletedCount): string
    {
        if ($savedCount === 0 && $deletedCount === 0) {
            return 'Tidak ada perubahan nilai yang disimpan.';
        }

        $parts = [];

        if ($savedCount > 0) {
            $parts[] = "{$savedCount} mata pelajaran disimpan atau diperbarui";
        }

        if ($deletedCount > 0) {
            $parts[] = "{$deletedCount} mata pelajaran dihapus";
        }

        return 'Pengelolaan nilai selesai: ' . implode(', ', $parts) . '.';
    }
}

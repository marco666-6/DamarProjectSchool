<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use App\Models\NilaiKriteria;
use App\Models\SekolahRekomendasi;
use App\Services\SawService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SekolahRekomendasiController extends Controller
{
    public function index(Request $request)
    {
        $query = SekolahRekomendasi::query();

        if ($search = $request->get('search')) {
            $query->where('nama_sekolah', 'like', "%{$search}%");
        }

        if ($jenis = $request->get('jenis')) {
            $query->where('jenis', $jenis);
        }

        if ($akreditasi = $request->get('akreditasi')) {
            $query->where('akreditasi', $akreditasi);
        }

        $sekolahList = $query->orderBy('nama_sekolah')->paginate(15)->withQueryString();

        return view('admin.sekolah-rekomendasi.index', compact('sekolahList'));
    }

    public function create()
    {
        $kriteriaList = Kriteria::active()->get();
        return view('admin.sekolah-rekomendasi.create', compact('kriteriaList'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_sekolah'     => ['required', 'string', 'max:255'],
            'npsn'             => ['nullable', 'string', 'max:20', 'unique:sekolah_rekomendasi,npsn'],
            'jenis'            => ['required', 'in:Negeri,Swasta'],
            'akreditasi'       => ['required', 'in:A,B,C,Belum Terakreditasi'],
            'alamat_sekolah'   => ['required', 'string'],
            'kecamatan'        => ['nullable', 'string', 'max:100'],
            'kota'             => ['nullable', 'string', 'max:100'],
            'latitude'         => ['nullable', 'numeric'],
            'longitude'        => ['nullable', 'numeric'],
            'fasilitas_sekolah'=> ['nullable', 'string'],
            'biaya_spp'        => ['nullable', 'numeric', 'min:0'],
            'biaya_masuk'      => ['nullable', 'numeric', 'min:0'],
            'phone'            => ['nullable', 'string', 'max:20'],
            'website'          => ['nullable', 'url'],
            'email'            => ['nullable', 'email'],
            'deskripsi'        => ['nullable', 'string'],
            'foto'             => ['nullable', 'image', 'max:2048'],
            'jumlah_siswa'     => ['nullable', 'integer'],
            'jumlah_guru'      => ['nullable', 'integer'],
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('sekolah', 'public');
        }

        $sekolah = SekolahRekomendasi::create($data);

        // Save nilai kriteria
        $this->saveNilaiKriteria($request, $sekolah->id);

        return redirect()->route('admin.sekolah-rekomendasi.index')
            ->with('success', 'Data sekolah berhasil ditambahkan.');
    }

    public function show(SekolahRekomendasi $sekolahRekomendasi)
    {
        $sekolahRekomendasi->load('nilaiKriteria.kriteria');
        return view('admin.sekolah-rekomendasi.show', ['sekolah' => $sekolahRekomendasi]);
    }

    public function edit(SekolahRekomendasi $sekolahRekomendasi)
    {
        $kriteriaList = Kriteria::active()->get();
        $nilaiMap     = $sekolahRekomendasi->nilaiKriteria->keyBy('kriteria_id');
        return view('admin.sekolah-rekomendasi.edit', [
            'sekolah'      => $sekolahRekomendasi,
            'kriteriaList' => $kriteriaList,
            'nilaiMap'     => $nilaiMap,
        ]);
    }

    public function update(Request $request, SekolahRekomendasi $sekolahRekomendasi)
    {
        $data = $request->validate([
            'nama_sekolah'     => ['required', 'string', 'max:255'],
            'npsn'             => ['nullable', 'string', 'max:20', 'unique:sekolah_rekomendasi,npsn,' . $sekolahRekomendasi->id],
            'jenis'            => ['required', 'in:Negeri,Swasta'],
            'akreditasi'       => ['required', 'in:A,B,C,Belum Terakreditasi'],
            'alamat_sekolah'   => ['required', 'string'],
            'kecamatan'        => ['nullable', 'string', 'max:100'],
            'kota'             => ['nullable', 'string', 'max:100'],
            'latitude'         => ['nullable', 'numeric'],
            'longitude'        => ['nullable', 'numeric'],
            'fasilitas_sekolah'=> ['nullable', 'string'],
            'biaya_spp'        => ['nullable', 'numeric', 'min:0'],
            'biaya_masuk'      => ['nullable', 'numeric', 'min:0'],
            'phone'            => ['nullable', 'string', 'max:20'],
            'website'          => ['nullable', 'url'],
            'email'            => ['nullable', 'email'],
            'deskripsi'        => ['nullable', 'string'],
            'foto'             => ['nullable', 'image', 'max:2048'],
            'jumlah_siswa'     => ['nullable', 'integer'],
            'jumlah_guru'      => ['nullable', 'integer'],
            'is_active'        => ['boolean'],
        ]);

        if ($request->hasFile('foto')) {
            if ($sekolahRekomendasi->foto) Storage::disk('public')->delete($sekolahRekomendasi->foto);
            $data['foto'] = $request->file('foto')->store('sekolah', 'public');
        }

        $data['is_active'] = $request->boolean('is_active', true);
        $sekolahRekomendasi->update($data);
        $this->saveNilaiKriteria($request, $sekolahRekomendasi->id);

        return redirect()->route('admin.sekolah-rekomendasi.index')
            ->with('success', 'Data sekolah berhasil diperbarui.');
    }

    public function destroy(SekolahRekomendasi $sekolahRekomendasi)
    {
        if ($sekolahRekomendasi->foto) Storage::disk('public')->delete($sekolahRekomendasi->foto);
        $sekolahRekomendasi->delete();

        return redirect()->route('admin.sekolah-rekomendasi.index')
            ->with('success', 'Data sekolah berhasil dihapus.');
    }

    /**
     * Show the full SAW decision matrix for all schools/criteria.
     */
    public function matriksKeputusan(SawService $saw)
    {
        $matrix   = $saw->getDecisionMatrix();
        $results  = $saw->hitung();
        $sekolahMap = SekolahRekomendasi::active()->get()->keyBy('id');

        return view('admin.sekolah-rekomendasi.matriks', compact('matrix', 'results', 'sekolahMap'));
    }

    // ── Private helpers ───────────────────────────────────────────────────────
    private function saveNilaiKriteria(Request $request, int $sekolahId): void
    {
        $nilaiData = $request->input('nilai_kriteria', []);
        foreach ($nilaiData as $kriteriaId => $nilai) {
            if ($nilai === null || $nilai === '') continue;
            NilaiKriteria::updateOrCreate(
                ['sekolah_id' => $sekolahId, 'kriteria_id' => $kriteriaId],
                ['nilai' => $nilai, 'keterangan' => $request->input("keterangan_kriteria.{$kriteriaId}")]
            );
        }
    }
}
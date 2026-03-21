<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    public function index(Request $request)
    {
        $query = MataPelajaran::with('guru');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mapel', 'like', "%{$search}%")
                  ->orWhere('kode_mapel', 'like', "%{$search}%");
            });
        }

        if ($kategori = $request->get('kategori')) {
            $query->where('kategori', $kategori);
        }

        $mapelList   = $query->orderBy('nama_mapel')->paginate(20)->withQueryString();
        $kategoriList = ['Wajib', 'Pilihan', 'Muatan Lokal', 'Agama', 'Ekstrakurikuler'];

        return view('admin.mata-pelajaran.index', compact('mapelList', 'kategoriList'));
    }

    public function create()
    {
        $guruList     = Guru::active()->orderBy('nama_guru')->get();
        $kategoriList = ['Wajib', 'Pilihan', 'Muatan Lokal', 'Agama', 'Ekstrakurikuler'];
        return view('admin.mata-pelajaran.create', compact('guruList', 'kategoriList'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_mapel'  => ['required', 'string', 'max:255'],
            'kode_mapel'  => ['nullable', 'string', 'max:20', 'unique:mata_pelajaran,kode_mapel'],
            'kategori'    => ['required', 'in:Wajib,Pilihan,Muatan Lokal,Agama,Ekstrakurikuler'],
            'guru_id'     => ['nullable', 'exists:guru,id'],
            'deskripsi'   => ['nullable', 'string'],
        ]);

        MataPelajaran::create($data);

        return redirect()->route('admin.mata-pelajaran.index')
            ->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function edit(MataPelajaran $mataPelajaran)
    {
        $guruList     = Guru::active()->orderBy('nama_guru')->get();
        $kategoriList = ['Wajib', 'Pilihan', 'Muatan Lokal', 'Agama', 'Ekstrakurikuler'];
        return view('admin.mata-pelajaran.edit', compact('mataPelajaran', 'guruList', 'kategoriList'));
    }

    public function update(Request $request, MataPelajaran $mataPelajaran)
    {
        $data = $request->validate([
            'nama_mapel'  => ['required', 'string', 'max:255'],
            'kode_mapel'  => ['nullable', 'string', 'max:20', 'unique:mata_pelajaran,kode_mapel,' . $mataPelajaran->id],
            'kategori'    => ['required', 'in:Wajib,Pilihan,Muatan Lokal,Agama,Ekstrakurikuler'],
            'guru_id'     => ['nullable', 'exists:guru,id'],
            'deskripsi'   => ['nullable', 'string'],
            'is_active'   => ['boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active', true);
        $mataPelajaran->update($data);

        return redirect()->route('admin.mata-pelajaran.index')
            ->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    public function destroy(MataPelajaran $mataPelajaran)
    {
        $mataPelajaran->delete();
        return redirect()->route('admin.mata-pelajaran.index')
            ->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}
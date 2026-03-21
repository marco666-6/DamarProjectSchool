<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::query();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_siswa', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        if ($kelas = $request->get('kelas')) {
            $query->where('kelas', $kelas);
        }

        $siswaList = $query->orderBy('nama_siswa')->paginate(15)->withQueryString();

        $kelasList = Siswa::active()
            ->selectRaw('kelas')
            ->distinct()
            ->orderBy('kelas')
            ->pluck('kelas');

        return view('admin.siswa.index', compact('siswaList', 'kelasList'));
    }

    public function create()
    {
        return view('admin.siswa.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nisn'               => ['required', 'string', 'max:20', 'unique:siswa,nisn'],
            'nis'                => ['nullable', 'string', 'max:20', 'unique:siswa,nis'],
            'nama_siswa'         => ['required', 'string', 'max:255'],
            'nama_orangtua'      => ['required', 'string', 'max:255'],
            'pekerjaan_orangtua' => ['nullable', 'string', 'max:100'],
            'phone_orangtua'     => ['nullable', 'string', 'max:20'],
            'alamat'             => ['required', 'string'],
            'tempat_lahir'       => ['nullable', 'string', 'max:100'],
            'tanggal_lahir'      => ['nullable', 'date'],
            'jenis_kelamin'      => ['nullable', 'in:L,P'],
            'kelas'              => ['nullable', 'string', 'max:10'],
            'tahun_masuk'        => ['nullable', 'integer', 'min:2000', 'max:2100'],
            'foto'               => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('siswa', 'public');
        }

        Siswa::create($data);

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function show(Siswa $siswa)
    {
        $siswa->load(['nilai.mataPelajaran', 'kegiatan']);
        return view('admin.siswa.show', compact('siswa'));
    }

    public function edit(Siswa $siswa)
    {
        return view('admin.siswa.edit', compact('siswa'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $data = $request->validate([
            'nisn'               => ['required', 'string', 'max:20', 'unique:siswa,nisn,' . $siswa->id],
            'nis'                => ['nullable', 'string', 'max:20', 'unique:siswa,nis,' . $siswa->id],
            'nama_siswa'         => ['required', 'string', 'max:255'],
            'nama_orangtua'      => ['required', 'string', 'max:255'],
            'pekerjaan_orangtua' => ['nullable', 'string', 'max:100'],
            'phone_orangtua'     => ['nullable', 'string', 'max:20'],
            'alamat'             => ['required', 'string'],
            'tempat_lahir'       => ['nullable', 'string', 'max:100'],
            'tanggal_lahir'      => ['nullable', 'date'],
            'jenis_kelamin'      => ['nullable', 'in:L,P'],
            'kelas'              => ['nullable', 'string', 'max:10'],
            'tahun_masuk'        => ['nullable', 'integer', 'min:2000', 'max:2100'],
            'foto'               => ['nullable', 'image', 'max:2048'],
            'is_active'          => ['boolean'],
        ]);

        if ($request->hasFile('foto')) {
            if ($siswa->foto) Storage::disk('public')->delete($siswa->foto);
            $data['foto'] = $request->file('foto')->store('siswa', 'public');
        }

        $data['is_active'] = $request->boolean('is_active', true);
        $siswa->update($data);

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa)
    {
        if ($siswa->foto) Storage::disk('public')->delete($siswa->foto);
        $siswa->delete();

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }
}
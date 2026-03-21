<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $query = Guru::with('user');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_guru', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $guruList = $query->orderBy('nama_guru')->paginate(15)->withQueryString();

        return view('admin.guru.index', compact('guruList'));
    }

    public function create()
    {
        return view('admin.guru.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nip'                  => ['nullable', 'string', 'max:30', 'unique:guru,nip'],
            'nama_guru'            => ['required', 'string', 'max:255'],
            'email'                => ['required', 'email', 'unique:users,email', 'unique:guru,email'],
            'password'             => ['required', 'min:8'],
            'phone'                => ['nullable', 'string', 'max:20'],
            'alamat'               => ['nullable', 'string'],
            'tempat_lahir'         => ['nullable', 'string', 'max:100'],
            'tanggal_lahir'        => ['nullable', 'date'],
            'jenis_kelamin'        => ['nullable', 'in:L,P'],
            'pendidikan_terakhir'  => ['nullable', 'string', 'max:50'],
            'foto'                 => ['nullable', 'image', 'max:2048'],
        ]);

        // Create user account for guru
        $user = User::create([
            'name'     => $data['nama_guru'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => 'guru',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('guru', 'public');
        }

        unset($data['password']);
        $data['user_id'] = $user->id;

        Guru::create($data);

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function show(Guru $guru)
    {
        $guru->load(['mataPelajaran', 'nilai.siswa', 'kegiatan.siswa']);
        return view('admin.guru.show', compact('guru'));
    }

    public function edit(Guru $guru)
    {
        return view('admin.guru.edit', compact('guru'));
    }

    public function update(Request $request, Guru $guru)
    {
        $data = $request->validate([
            'nip'                  => ['nullable', 'string', 'max:30', 'unique:guru,nip,' . $guru->id],
            'nama_guru'            => ['required', 'string', 'max:255'],
            'email'                => ['required', 'email', 'unique:guru,email,' . $guru->id],
            'phone'                => ['nullable', 'string', 'max:20'],
            'alamat'               => ['nullable', 'string'],
            'tempat_lahir'         => ['nullable', 'string', 'max:100'],
            'tanggal_lahir'        => ['nullable', 'date'],
            'jenis_kelamin'        => ['nullable', 'in:L,P'],
            'pendidikan_terakhir'  => ['nullable', 'string', 'max:50'],
            'foto'                 => ['nullable', 'image', 'max:2048'],
            'is_active'            => ['boolean'],
            'new_password'         => ['nullable', 'min:8'],
        ]);

        if ($request->hasFile('foto')) {
            if ($guru->foto) Storage::disk('public')->delete($guru->foto);
            $data['foto'] = $request->file('foto')->store('guru', 'public');
        }

        if (!empty($data['new_password'])) {
            $guru->user->update(['password' => Hash::make($data['new_password'])]);
        }
        unset($data['new_password']);

        // Sync user name & email
        $guru->user->update([
            'name'  => $data['nama_guru'],
            'email' => $data['email'],
        ]);

        $data['is_active'] = $request->boolean('is_active', true);
        $guru->update($data);

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(Guru $guru)
    {
        if ($guru->foto) Storage::disk('public')->delete($guru->foto);
        $guru->user?->delete(); // cascade deletes guru via FK
        // If user doesn't cascade, delete guru directly
        if ($guru->exists) $guru->delete();

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data guru berhasil dihapus.');
    }
}
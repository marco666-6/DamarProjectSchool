<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $guru = $user->isGuru() ? $user->guru : null;
        return view('profile.show', compact('user', 'guru'));
    }

    public function edit()
    {
        $user = Auth::user();
        $guru = $user->isGuru() ? $user->guru : null;
        return view('profile.edit', compact('user', 'guru'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'phone'        => ['nullable', 'string', 'max:20'],
            'alamat'       => ['nullable', 'string'],
            'tempat_lahir' => ['nullable', 'string', 'max:100'],
            'tanggal_lahir'=> ['nullable', 'date'],
            'foto'         => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('foto')) {
            if ($user->foto) Storage::disk('public')->delete($user->foto);
            $data['foto'] = $request->file('foto')->store('profiles', 'public');
        }

        $user->update($data);

        // Sync guru profile name if applicable
        if ($user->isGuru() && $user->guru) {
            $user->guru->update([
                'nama_guru'    => $data['name'],
                'phone'        => $data['phone'] ?? $user->guru->phone,
                'alamat'       => $data['alamat'] ?? $user->guru->alamat,
                'tempat_lahir' => $data['tempat_lahir'] ?? $user->guru->tempat_lahir,
                'tanggal_lahir'=> $data['tanggal_lahir'] ?? $user->guru->tanggal_lahir,
            ]);
        }

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password'         => ['required', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return redirect()->route('profile.show')->with('success', 'Password berhasil diubah.');
    }
}